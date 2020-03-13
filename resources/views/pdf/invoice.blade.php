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

            table {
                border-collapse: collapse;
            }

            table thead {
                color: #672767;
            }

            .table>thead>tr>th {
                border-bottom: 0;
            }

            .table>thead>tr:first-child>th {
                padding: 15px 5px;
            }

            .table>tbody>tr:nth-of-type(1)>td {
                border-top: 0;
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
                    <img class="img-responsive" src="{{ public_path('assets/img/logos/' . $invoice->establishment->logo) }}" alt="Logotype {{ $invoice->establishment->name }}" />
                </div>

                <div class="col-xs-3">
                </div>

                <div class="col-xs-4">
                    <address class="small text-right">
                        <strong style="color: #672767;">{{ $invoice->establishment->name }}</strong><br>
                        @isset($invoice->establishment->address_line1){{ $invoice->establishment->address_line1 }}<br>@endisset
                        @isset($invoice->establishment->address_line2){{ $invoice->establishment->address_line2 }}<br>@endisset
                        @isset($invoice->establishment->address_line3){{ $invoice->establishment->address_line3 }}<br>@endisset
                        {{ $invoice->establishment->postcode }} {{ $invoice->establishment->city }}<br>
                        @isset($invoice->establishment->phone)<abbr title="Téléphone">Tél.</abbr> {{ $invoice->establishment->phone }}<br>@endisset
                        @isset($invoice->establishment->email)<a href="mailto:{{ $invoice->establishment->email }}" class="small">{{ $invoice->establishment->email }}</a>@endisset
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-4">
                    <h3 style="margin: 0;"><small style="color: #672767;">Facture</small></h3>
                    <h1 style="margin: 5px 0 0 0;"><small style="font-size: 25px; color: #3D1152;">#{{ $invoice->invoice_no }}</small></h1>
                </div>

                <div class="col-xs-3">
                    <h4 style="margin: 0;"><small style="color: #672767;">Date d'émission</small></h4>
                    <p style="margin: 0;">{{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</p>

                    <div style="margin-bottom: 0px">&nbsp;</div>

                    <h4 style="margin: 0;"><small style="color: #672767;">Date d'échéance</small></h4>
                    <p style="margin: 0;">{{ date('d/m/Y', strtotime($invoice->due_date)) }}</p>
                </div>

                <div class="col-xs-4">
                    <address>
                        <strong style="color: #672767;">{{ $invoice->third->name }}</strong><br>
                        @isset($invoice->third->address_line1){{ $invoice->third->address_line1 }}<br>@endisset
                        @isset($invoice->third->address_line2){{ $invoice->third->address_line2 }}<br>@endisset
                        @isset($invoice->third->address_line3){{ $invoice->third->address_line3 }}<br>@endisset
                        {{ $invoice->third->postcode }} {{ $invoice->third->city }}
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

{{--            TODO: delivery address--}}
            <table class="table table-condensed">
                <thead style="border-top: 5px solid #672767;">
                    <tr>
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
                                    <strong>{{ $line->name }}</strong>
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
                    <h4 style="margin: 0;"><small style="color: #672767;">Règlement</small></h4>
                    <p style="margin: 0;">{{ $invoice->third->payment->name }}</p>

                    <div style="margin-bottom: 0px">&nbsp;</div>

                    <h4 style="margin: 0;"><small style="color: #672767;">N° TVA</small></h4>
                    <p style="margin: 0;">{{ $invoice->third->intracommunity_no }}</p>
                </div>
                <div class="col-xs-4">
                    <table style="width: 100%;">
                        <tbody>
                            <tr style="padding: 5px;">
                                <th style="padding: 5px; font-weight: normal;" class="text-right">Sous-total</th>
                                <td style="padding: 5px;" class="text-right">{{ round($invoice->total_pretax, 2) }}€</td>
                            </tr>
                            <tr style="padding: 5px;">
                                <th style="padding: 5px; font-weight: normal;" class="text-right">Réduction</th>
                                <td style="padding: 5px;" class="text-right">{{ round($invoice->discount_amount, 2) }}€</td>
                            </tr>
                            <tr style="padding: 5px;">
                                <th style="padding: 5px; font-weight: normal;" class="text-right">Total HT</th>
                                <td style="padding: 5px;" class="text-right">{{ round($invoice->total_pretax, 2) }}€</td>
                            </tr>
                            <tr style="padding: 5px;">
                                <th style="padding: 5px; font-weight: normal;" class="text-right">Total TVA</th>
                                <td style="padding: 5px;" class="text-right">{{ round($invoice->vat, 2) }}€</td>
                            </tr>
                            <tr style="padding: 5px;">
                                <th style="padding: 5px; color: #672767;" class="text-right">Total TTC</th>
                                <td style="padding: 5px;" class="text-right"><strong>{{ round($invoice->total, 2) }}€</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-12">
                    <h4 style="margin: 0;"><small style="color: #672767;">Conditions de vente</small></h4>
                    @if($invoice->third->bank_rate === 0 || $invoice->third->discount_duration === 0)
                        <p class="small" style="margin: 0;">Pas d'escompte pour paiement anticipé</p>
                    @else
                        <p class="small" style="margin: 0;">Escompte de {{ $invoice->third->bank_rate }}% pour règlement anticipé avant le {{ date('d/m/Y', strtotime($invoice->invoice_date. ' + ' . $invoice->third->discount_duration . ' days')) }}.</p>
                    @endif

                    <dl class="small" style="margin: 0;">
                        @foreach(explode("\n", $invoice->establishment->foot_invoice) as $term)
                            <dd>{{ $term }}</dd>
                        @endforeach
                    </dl>
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
