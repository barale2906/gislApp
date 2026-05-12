<?php

namespace App\Exports\Facturacion;

use App\Models\Facturacion\Factura;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

final class FacturasDashboardExport implements WithMultipleSheets
{
    public function __construct(
        private array $dashboard,
        private string $fechaDesde,
        private string $fechaHasta,
        private string $busqueda,
        private Collection $facturas,
    ) {}

    public function sheets(): array
    {
        return [
            new FacturasDashboardResumenSheet($this->dashboard, $this->fechaDesde, $this->fechaHasta, $this->busqueda),
            new FacturasDashboardPorEmpresaSheet($this->dashboard['por_empresa'] ?? collect()),
            new FacturasDashboardAnuladasSheet($this->dashboard['facturas_anuladas'] ?? collect()),
            new FacturasDashboardFacturasSheet($this->facturas),
        ];
    }
}

final class FacturasDashboardResumenSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(
        private array $dashboard,
        private string $fechaDesde,
        private string $fechaHasta,
        private string $busqueda,
    ) {}

    public function title(): string
    {
        return 'Resumen KPI';
    }

    public function headings(): array
    {
        return ['Concepto', 'Valor'];
    }

    public function collection(): Collection
    {
        $busq = trim($this->busqueda) !== '' ? $this->busqueda : '—';

        return collect([
            ['Período desde (fecha factura)', $this->fechaDesde],
            ['Período hasta (fecha factura)', $this->fechaHasta],
            ['Texto de búsqueda aplicado', $busq],
            ['Valor facturado neto (solo enviadas y pagadas, est. 2 y 3)', $this->dashboard['valor_facturado']],
            ['Facturas en período (todas las del rango)', $this->dashboard['total_facturas']],
            ['Empresas con al menos una factura en período', $this->dashboard['empresas_con_facturas']],
            ['Facturas anuladas (est. 4 y 5), cantidad', $this->dashboard['facturas_anuladas_cantidad']],
            ['Facturas anuladas, monto referencia (total − descuento)', $this->dashboard['facturas_anuladas_monto_referencia']],
        ]);
    }
}

final class FacturasDashboardPorEmpresaSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(
        private Collection $filas,
    ) {}

    public function title(): string
    {
        return 'Por empresa';
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Facturas en período (todas)',
            'Números (solo enviadas/pagadas)',
            'Total neto (solo enviadas/pagadas)',
        ];
    }

    public function collection(): Collection
    {
        return $this->filas->map(fn ($f) => [
            $f->cliente,
            (int) $f->cantidad,
            $f->numeros ?? '',
            (float) $f->total_neto,
        ]);
    }
}

final class FacturasDashboardAnuladasSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(
        private Collection $filas,
    ) {}

    public function title(): string
    {
        return 'Anuladas';
    }

    public function headings(): array
    {
        return ['Cliente', 'Fecha', 'Número', 'Neto', 'Estado'];
    }

    public function collection(): Collection
    {
        return $this->filas->map(function ($fa) {
            $neto = (float) $fa->total - (float) $fa->descuento;
            $num = $fa->numero !== null && $fa->numero !== '' ? (string) $fa->numero : 'P-'.$fa->id;
            $fecha = $fa->fecha ? Carbon::parse($fa->fecha)->format('Y-m-d') : '';
            $est = (int) $fa->status === 4 ? 'Anulada (4)' : 'Anulada (5)';

            return [$fa->cliente, $fecha, $num, $neto, $est];
        });
    }
}

final class FacturasDashboardFacturasSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(
        private Collection $facturas,
    ) {}

    public function title(): string
    {
        return 'Facturas';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Empresa ID',
            'Lista',
            'Número',
            'Fecha',
            'Vencimiento',
            'Cliente',
            'Total',
            'Descuento',
            'Neto',
            'Estado',
            'Observaciones',
        ];
    }

    public function collection(): Collection
    {
        return $this->facturas->map(function (Factura $f) {
            $neto = (float) $f->total - (float) $f->descuento;
            $obs = (string) ($f->observaciones ?? '');
            if (mb_strlen($obs) > 2000) {
                $obs = mb_substr($obs, 0, 2000).'…';
            }

            return [
                $f->id,
                $f->empresa_id,
                $f->lista?->name ?? '',
                $f->numero,
                $f->fecha ? Carbon::parse($f->fecha)->format('Y-m-d') : '',
                $f->vencimiento ? Carbon::parse($f->vencimiento)->format('Y-m-d') : '',
                $f->cliente,
                (float) $f->total,
                (float) $f->descuento,
                $neto,
                self::statusLabel((int) $f->status),
                $obs,
            ];
        });
    }

    private static function statusLabel(int $s): string
    {
        return match ($s) {
            1 => 'En proceso',
            2 => 'Enviada',
            3 => 'Pagada',
            4 => 'Anulada (4)',
            5 => 'Anulada (5)',
            default => (string) $s,
        };
    }
}
