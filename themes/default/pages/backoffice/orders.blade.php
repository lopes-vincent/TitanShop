@extends('default.templates.backoffice')

@section('page.content')
    <div class="row mx-0">
        <div class="col-12 d-flex justify-content-between">
            <h1>Commandes {!! isset($status) ? '- <span class="text-with-background">' . $status->i18nValue('title') . '</span>': ''  !!}</h1>
        </div>
        <div class="col-12 d-flex justify-content-between">
            <div class="admin-breadcrumb mb-3">
                <a href='{{ route('admin.homepage') }}'><i class="fa fa-home" aria-hidden="true"></i></a> /
                <a href='{{ route('admin.orders') }}'>Commandes</a>
                @if (isset($status))
                / <a href='{{ route('admin.orders', ['status' => $status]) }}'>{{ $status->i18nValue('title') }}</a>
                @endif
            </div>
        </div>
        <div class="col-lg-12">
            <div class="bg-white p-0 mb-3 border shadow-sm backoffice-card">
                @if(isset($orders) && 0 < count($orders))
                <table class="table bg-white">
                    <thead class="thead-default">
                    <tr>
                        <th class="d-table-cell d-md-none">Résumé</th>
                        <th class="d-none d-md-table-cell">ID</th>
                        <th class="d-none d-md-table-cell">Commande passée le</th>
                        <th class="d-none d-md-table-cell">Client</th>
                        <th class="d-none d-md-table-cell">Paiement</th>
                        <th class="d-none d-md-table-cell">Status</th>
                        <th class="text-center d-none d-md-table-cell">Token</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="d-table-cell d-md-none">
                                <p>{{$order->created_at->format('d/m/Y à H\hi')}}</p>
                                <p>{!! $order->status->generateBadge() !!}</p>
                                <p>
                                    <b>
                                        {!! $order->customer != null
                                            ? "<a href='" . route('admin.customer.show', ['customer' => $order->customer]) . " '>" . $order->customerIdentity . "</a>"
                                            : $order->customerIdentity !!}
                                    </b>
                                </p>
                                <p>{{$order->totalPriceFormatted}} - {{$order->paymentMethod}}</p>
                            </td>

                            <td class="d-none d-md-table-cell">{{$order->id}}</td>
                            <td class="d-none d-md-table-cell">{{$order->created_at->format('d/m/Y à H\hi')}}</td>
                            <td class="d-none d-md-table-cell">
                                <b>
                                    {!! $order->customer != null
                                        ? "<a href='" . route('admin.customer.show', ['customer' => $order->customer]) . " '>" . $order->customerIdentity . "</a>"
                                        : $order->customerIdentity !!}</b> <br>
                                {{$order->email}} @if ($order->phone)- {{$order->phone}}@endif
                            </td>
                            <td class="d-none d-md-table-cell">{{$order->totalPriceFormatted}} - {{$order->paymentMethod}}</td>
                            <td class="d-none d-md-table-cell">{!! $order->status->generateBadge() !!}</td>
                            <td class="text-center d-none d-md-table-cell"><span class="order-token">{{$order->token}}</span></td>

                            <td class="text-right">
                                <a class="btn btn-primary text-white" href="{{route('admin.order.show', ['order' => $order])}}">
                                    <i class="fa fa-eye"></i>
                                    Voir la commande</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else

                <p class="p-3 text-center">Aucune commande n'a été effectuée sur le site pour le moment.</p>

            @endif
            </div>
        </div>
    </div>
@endsection
