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
                    <img src="{{ asset('/assets/img/logos/' . $invoice->establishment->logo) }}"
                         alt="Logotype {{ $invoice->establishment->name }}" />
                </div>
            </div>

            <div class="row border-bottom">
                <div class="col-xs-3">
                </div>
                <div class="col-xs-8">
                    <address class="small text-right">
                        <strong>{{ $invoice->establishment->name }}</strong>,
                        @isset($invoice->establishment->address_line1){{ $invoice->establishment->address_line1 }}, @endisset
                        @isset($invoice->establishment->address_line2){{ $invoice->establishment->address_line2 }}, @endisset
                        @isset($invoice->establishment->address_line3){{ $invoice->establishment->address_line3 }}, @endisset
                        {{ $invoice->establishment->zipcode }} {{ $invoice->establishment->city }}<br>
                        @isset($invoice->establishment->phone)<abbr title="Téléphone">Tél.</abbr> {{ $invoice->establishment->phone }} | @endisset
                        @isset($invoice->establishment->email)<a href="mailto:{{ $invoice->establishment->email }}" class="small">{{ $invoice->establishment->email }}</a>@endisset
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-4">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Facture</th>
                                <td class="text-right">#{{ $invoice->id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</td>
                            </tr>
                            <tr>
                                <th>Date d'échéance</th>
                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->due_date)) }}</td>
                            </tr>
                            <tr>
                                <th>Suivi par</th>
                                <td class="text-right">{{ $invoice->salesperson->name }} {{ $invoice->salesperson->surname }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-2">
                </div>

                <div class="col-xs-5">
                    <address class="small text-right">
                        <strong>{{ $invoice->third->name }}</strong>,
                        @isset($invoice->third->address_line1){{ $invoice->third->address_line1 }}, @endisset
                        @isset($invoice->third->address_line2){{ $invoice->third->address_line2 }}, @endisset
                        @isset($invoice->third->address_line3){{ $invoice->third->address_line3 }}, @endisset
                        {{ $invoice->third->zipcode }} {{ $invoice->third->city }}
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Description</th>
{{--                        <th>TVA</th>--}}
                        <th>Quantité</th>
                        <th>Remise</th>
                        <th>Prix unitaire</th>
                        <th class="text-right">Total HT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->lines as $line)
                        <tr>
                            @if ($line->type === "comment")
                                <td colspan="5">
                                    <dl>
                                        @foreach(explode("\n", $line->description) as $description)
                                            <dd>{{ $description }}</dd>
                                        @endforeach
                                    </dl>
                                </td>
                            @else
                                <td colspan="5">
                                    <dl>
                                        @foreach(explode("\n", $line->description) as $description)
                                            <dd>{{ $description }}</dd>
                                        @endforeach
                                    </dl>
                                </td>
                                <td>%</td>
                                <td>{{ $line->quantity }}</td>
                                <td>{{ $line->discount_rate }}%</td>
                                <td>{{ round($line->unit_price, 2) }}</td>
                                <td class="text-right">{{ round($line->total_pretax, 2) }}€</td>
                            @endif
                        </tr>

                        @php echo $line @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-xs-6">
                    <h5>Payment terms and methods</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam cursus sem sed diam dapibus, vel eleifend enim scelerisque. Aenean id tempus enim.</p>
                </div>
                <div class="col-xs-5">
                    <table style="width: 100%">
                        <tbody>
                            <tr style="padding: 5px">
                                <th style="padding: 5px"><div>Subtotal</div></th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->total_pretax, 2) }}€</strong></td>
                            </tr>
                            <tr style="padding: 5px">
                                <th style="padding: 5px"><div>Total TVA (20%)</div></th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->discount_amount, 2) }}€</strong></td>
                            </tr>
                            <tr class="well" style="padding: 5px">
                                <th style="padding: 5px"><div>Total TTC</div></th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->total, 2) }}€</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

{{--            <div class="row">--}}
{{--                <div class="col-xs-12">--}}
{{--                    <p>{{ $invoice->user->company->foot_quotation }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row" style="border-top: 1px solid #ddd;">--}}
{{--                <div class="col-xs-12">--}}
{{--                    <p class="text-center">{{ $invoice->user->company->siret }} | {{ $invoice->user->company->tva }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        @if (!$loop->last) <div class="page-break"></div> @endif
        @endforeach
    </body>
</html>
