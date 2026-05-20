<?php

namespace App\Exports\Diligencia;

use App\Models\Diligencias\Diligencia;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

final class DiligenciasClienteExport implements WithMultipleSheets
{
    public function __construct(
        private Collection $diligencias,
        private string $contextoLista,
        private string $empresaNombre,
    ) {}

    public function sheets(): array
    {
        return [
            new DiligenciasClienteResumenSheet(
                $this->empresaNombre,
                $this->contextoLista,
                $this->diligencias->count(),
            ),
            new DiligenciasClienteDatosSheet($this->diligencias),
        ];
    }
}

final class DiligenciasClienteResumenSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(
        private string $empresaNombre,
        private string $contextoLista,
        private int $total,
    ) {}

    public function title(): string
    {
        return 'Resumen';
    }

    public function headings(): array
    {
        return ['Concepto', 'Valor'];
    }

    public function collection(): Collection
    {
        return collect([
            ['Empresa', $this->empresaNombre],
            ['Alcance del archivo', $this->contextoLista],
            ['Total de diligencias exportadas', $this->total],
            ['Generado el', Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}

final class DiligenciasClienteDatosSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithColumnFormatting
{
    public function __construct(
        private Collection $diligencias,
    ) {}

    public function title(): string
    {
        return 'Diligencias';
    }

    /**
     * @return array<string, string>
     */
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_0,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Identificador',
            'Estado diligencia',
            'Guías',
            'Tipo',
            'Fecha creación',
            'Empresa',
            'Remitente (operador creación)',
            'Sucursal origen',
            'Área origen',
            'Fecha entrega programada',
            'Fecha recepción',
            'Destinatario',
            'Sucursal destino',
            'Área destino',
            'Dirección',
            'Ciudad',
            'Descripción',
            'Detalle contenido',
            'Observaciones internas',
            'Mensajeros / asignaciones',
            'Estado facturación',
            'N° factura asociada',
            'Cobro',
        ];
    }

    public function collection(): Collection
    {
        return $this->diligencias->map(fn (Diligencia $d) => $this->mapRow($d));
    }

    /**
     * @return array<int, mixed>
     */
    private function mapRow(Diligencia $d): array
    {
        $mensajerosTxt = $d->mensajeros->map(function ($m) {
            $nombre = $m->mensajero?->name ?? '(usuario)';
            $est = self::estadoMensajero((int) $m->status);

            return "{$nombre} [{$est}]";
        })->implode(' | ');

        return [
            $d->id,
            $d->identificador,
            self::estadoDiligencia((int) $d->status),
            round((float) $d->guias, 1),
            self::tipoDiligencia((int) $d->tipo),
            $d->created_at ? Carbon::parse($d->created_at)->format('Y-m-d H:i') : '',
            $d->empresa?->name ?? '',
            $d->ubica?->user?->name ?? '',
            $d->ubica?->sucursal?->name ?? '',
            $d->ubica?->area?->name ?? '',
            $d->fecha_entrega ? Carbon::parse($d->fecha_entrega)->format('Y-m-d') : '',
            $d->fecha_recepcion ? Carbon::parse($d->fecha_recepcion)->format('Y-m-d') : '',
            $d->name_dest,
            $d->sucursal_dest,
            $d->area_dest,
            self::truncate($d->direccion_dest ?? '', 2000),
            $d->ciudad?->name ?? '',
            self::truncate($d->descripcion ?? '', 2000),
            self::truncate($d->detalle ?? '', 2000),
            self::truncate($d->observaciones ?? '', 2000),
            self::truncate($mensajerosTxt, 2000),
            self::estadoFactura((int) $d->status_factura),
            self::numeroFacturaAsociada($d),
            (float) $d->cobro,
        ];
    }

    private static function numeroFacturaAsociada(Diligencia $d): string
    {
        $f = $d->facturaAsociada;
        if (! $f) {
            return '';
        }
        if ($f->numero !== null && $f->numero !== '') {
            return (string) $f->numero;
        }

        return 'P-'.$f->id;
    }

    private static function truncate(string $text, int $max): string
    {
        if (mb_strlen($text) <= $max) {
            return $text;
        }

        return mb_substr($text, 0, $max - 1).'…';
    }

    private static function estadoDiligencia(int $s): string
    {
        return match ($s) {
            1 => 'Creado',
            2 => 'Asignado',
            3 => 'En proceso',
            4 => 'Entregada destinatario',
            5 => 'Ejecutada (cierro yo)',
            6 => 'Cerrada (cliente)',
            7 => 'Legalizada mensajero',
            8 => 'Devolución',
            9 => 'Cancelada',
            10 => 'Frecuente',
            default => 'Estado '.$s,
        };
    }

    private static function estadoMensajero(int $s): string
    {
        return match ($s) {
            1 => 'Asignado',
            2 => 'Recogido',
            3 => 'Entregado',
            4 => 'Reasignado',
            default => 'M-'.$s,
        };
    }

    private static function estadoFactura(int $s): string
    {
        return match ($s) {
            1 => 'Sin facturar',
            2 => 'Asignada a factura',
            3 => 'Facturada',
            4 => 'Prepagada',
            5 => 'No cobrar',
            default => 'F-'.$s,
        };
    }

    private static function tipoDiligencia(int $t): string
    {
        return match ($t) {
            1 => 'Interna',
            2 => 'Externa',
            3 => 'A otras ciudades',
            default => 'T-'.$t,
        };
    }
}
