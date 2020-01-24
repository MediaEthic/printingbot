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
{{--                    <img src="{{ asset('/assets/img/logo-ethic-software.png') }}"--}}
{{--                         alt="Logotype Ethic Software"--}}
{{--                         class="main-logo" />--}}
                </div>
            </div>

            <div class="row border-bottom">
                <div class="col-xs-3">
                </div>
                <div class="col-xs-8">
                    <address class="small text-right">
                        <strong>Ethic</strong>,
                        2 place du Réduit
                        64100 BAYONNE<br>
                        <abbr title="Téléphone">Tél.</abbr> +33 (0)5 59 20 81 31 |
                        <a href="mailto:info@ethicsoftware.com" class="small">info@ethicsoftware.com</a>
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <div class="row">
                <div class="col-xs-4">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Devis</th>
                                <td class="text-right">#{{ $invoice->id }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->updated_at)) }}</td>
                            </tr>
                            <tr>
                                <th>Date d'échéance</th>
                                <td class="text-right">{{ date('d/m/Y', strtotime($invoice->due_date)) }}</td>
                            </tr>
                            <tr>
                                <th>Suivi par</th>
                                <td class="text-right">Gilles BONIN</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-2">
                </div>

                <div class="col-xs-5">
                    <address>
                        <strong>{{ $invoice->client}}</strong><br>
                        {{ $invoice->client_address }}<br>
                        64600 ANGLET
                    </address>
                </div>
            </div>

            <div style="margin-bottom: 0px">&nbsp;</div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->lines as $line)
                        <tr>
                            <td>
                                <strong>{{ $line->name }}</strong><br>
                                <dl>
                                    @foreach(explode("\n", $line->description) as $description)
                                        <dd>{{ $description }}</dd>
                                    @endforeach
                                </dl>
                            </td>
                            <td>{{ $line->qty }}</td>
                            <td>{{ round($line->price, 2) }}</td>
                            <td class="text-right">{{ round($line->total, 2) }}€</td>
                        </tr>
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
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->sub_total, 2) }}€</strong></td>
                            </tr>
                            <tr style="padding: 5px">
                                <th style="padding: 5px"><div>Total TVA (20%)</div></th>
                                <td style="padding: 5px" class="text-right"><strong>{{ round($invoice->discount, 2) }}€</strong></td>
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
