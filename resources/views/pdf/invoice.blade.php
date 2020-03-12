<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <title>Invoices</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            .page-break {
                page-break-after: always;
            }

            .small {
                font-size: 12px;
                line-height: 1.228;
            }

            table thead {
                text-transform: uppercase;
                color: #E2D1DE;
            }
        </style>
    </head>

    <body>
    <script type="text/php">
            if (isset($pdf)) {
                $x = 290;
                $y = 820;
                $text = "{PAGE_NUM} / {PAGE_COUNT}";
                $font = null;
                $size = 10;
                $color = array(0, 0, 0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                if ($PAGE_COUNT > 1) {
                    $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                }
            }
        </script>


        @foreach($invoices as $invoice)
        <div>
            <div class="row">
                <div class="col-xs-3">
                    <img style="width: 100%;" src="{{ public_path('assets/img/logos/' . $invoice->establishment->logo) }}" alt="Logotype {{ $invoice->establishment->name }}" />
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3">
                </div>
                <div class="col-xs-8">
                    <address class="small text-right">
                        <strong>{{ $invoice->establishment->name }}</strong>,
                        @isset($invoice->establishment->address_line1){{ $invoice->establishment->address_line1 }}, @endisset
                        @isset($invoice->establishment->address_line2){{ $invoice->establishment->address_line2 }}, @endisset
                        @isset($invoice->establishment->address_line3){{ $invoice->establishment->address_line3 }}, @endisset
                        {{ $invoice->establishment->postcode }} {{ $invoice->establishment->city }}<br>
                        @isset($invoice->establishment->phone)<abbr title="Téléphone">Tél.</abbr> {{ $invoice->establishment->phone }} | @endisset
                        @isset($invoice->establishment->email)<a href="mailto:{{ $invoice->establishment->email }}" class="small">{{ $invoice->establishment->email }}</a>@endisset
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-4">
                    <h1><small style="color: #672767;">Facture #{{ $invoice->invoice_no }}</small></h1>
                    <table class="table table-striped table-condensed" style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Date d'émission</th>
                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</td>
                            </tr>
                            <tr>
                                <th>Date d'échéance</th>
                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->due_date)) }}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <th>Emise par</th>--}}
{{--                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->due_date)) }}</td>--}}
{{--                            </tr>--}}
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-3">
                </div>

                <div class="col-xs-4">
                    <address class="">
                        <strong>{{ $invoice->third->name }}</strong><br>
                        @isset($invoice->third->address_line1){{ $invoice->third->address_line1 }}<br>@endisset
                        @isset($invoice->third->address_line2){{ $invoice->third->address_line2 }}<br>@endisset
                        @isset($invoice->third->address_line3){{ $invoice->third->address_line3 }}<br>@endisset
                        {{ $invoice->third->postcode }} {{ $invoice->third->city }}
                    </address>
                </div>
            </div>

{{--            TODO: delivery address--}}
            <table class="table table-condensed" style="border-radius: 15px; overflow: hidden;">
                <thead style="border-bottom: 0;">
                    <tr style="background-color: #3D1152; border-bottom: 0;">
                        <th>Description</th>
                        <th>TVA</th>
                        <th>Qté</th>
                        <th>Réduction</th>
                        <th>PU</th>
                        <th class="text-right">Total HT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->lines as $line)
                        <tr>
                            @if ($line->type === "comment")
                                <td colspan="6">
                                    <dl>
                                        @foreach(explode("\n", $line->description) as $description)
                                            <dd>{{ $description }}</dd>
                                        @endforeach
                                    </dl>
                                </td>
                            @else
                                <td>
                                    <strong style="color: #672767;">{{ $line->name }}</strong>
                                    <dl>
                                        @foreach(explode("\n", $line->description) as $description)
                                            <dd>{{ $description }}</dd>
                                        @endforeach
                                    </dl>
                                </td>
                                <td>{{ $line->vat->rate }}%</td>
                                <td>{{ $line->quantity }}</td>
                                <td>{{ $line->discount_rate }}%</td>
                                <td>{{ round($line->unit_price, 2) }}</td>
                                <td class="text-right">{{ round($line->total_pretax, 2) }}€</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-xs-7">
                    <p style="margin: 0;">Règlement par {{ $invoice->third->payment->name }}</p>
                    @isset($invoice->third->intracommunity_no)<p><small>TVA intracommunautaire : {{ $invoice->third->intracommunity_no }}</small></p>@endisset
                </div>
                <div class="col-xs-4">
                    <table  style="width: 100%">
                        <tbody>
                            <tr style="padding: 5px">
                                <th style="padding: 5px">Sous-total</th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->total_pretax, 2) }}€</strong></td>
                            </tr>
                            <tr style="padding: 5px">
                                <th style="padding: 5px">Réduction</th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->discount_amount, 2) }}€</strong></td>
                            </tr>
                            <tr style="padding: 5px">
                                <th style="padding: 5px">Total HT</th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->total_pretax, 2) }}€</strong></td>
                            </tr>
                            <tr style="padding: 5px">
                                <th style="padding: 5px">Total TVA</th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->vat, 2) }}€</strong></td>
                            </tr>
                            <tr class="well" style="padding: 5px">
                                <th style="padding: 5px"><div>Total TTC</div></th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->total, 2) }}€</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    @if($invoice->third->bank_rate === 0 || $invoice->third->discount_duration === 0)
                        <p class="small" style="margin: 0;">Pas d'escompte pour paiement anticipé</p>
                    @else
                        <p class="small" style="margin: 0;">Escompte de {{ $invoice->third->bank_rate }}% pour règlement anticipé avant le {{ date('d/m/Y', strtotime($invoice->invoice_date. ' + ' . $invoice->third->discount_duration . ' days')) }}.</p>
                    @endif
                    <p class="small" style="margin: 0;">{{ $invoice->establishment->foot_invoice }}</p>
                </div>
            </div>

            <div class="row" style="position: absolute; bottom: 0;">
                <div class="col-xs-12">
                    <p class="small text-center" style="margin: 0;">
                        <strong>{{ $invoice->establishment->company->name }}</strong> |
                        {{ $invoice->establishment->company->legal_form }} au capital de {{ $invoice->establishment->company->capital }}€ |
                        Code APE {{ $invoice->establishment->company->ape }} |
                        RCS {{ $invoice->establishment->company->register }} |
                        N° TVA {{ $invoice->establishment->company->tva }}

                    </p>
                </div>
            </div>
        </div>
        @if (!$loop->last) <div class="page-break"></div> @endif
        @endforeach
    </body>
</html>
