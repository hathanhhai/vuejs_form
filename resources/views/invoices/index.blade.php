@extends('layouts.master')
@section('content')
        <br>
    <div class="panel panel-default">

        <div class="panel-heading">

            <div class="clearfix">
                <span class="panel-title">Invoices</span>
                <a href="{{route('invoices.create')}}" class="btn btn-success pull-right">Create</a>
            </div>

        </div>

        <div class="panel-body">

            @if($invoices->count())

                <table class="table table-striped">

                    <thead>

                        <th>Invoices No.</th>
                        <th>Grand Total</th>
                        <th>Client</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th colspan="2">Created At</th>

                    </thead>

                    <tbody>

                        @foreach($invoices as $item)
                            <tr>
                            <td>{!! $item->invoice_no !!}</td>
                            <td>{!! $item->grand_total !!}</td>
                            <td>{!! $item->client !!}</td>
                            <td>{!! $item->due_date !!}</td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>

                                    <a href="{{route('invoices.edit',$item)}}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{route('invoices.show',$item->id)}}" class="btn btn-primary btn-sm">Show</a>
                                    <form class="form-inline" method="post" action="{{route('invoices.destroy',$item->id)}}">
                                <input  type="hidden" name="_token" value="{{csrf_token()}}" />
                                <input name="_method" type="hidden" value="delete" />
                                        <input type="submit" value="Delete" class="btn btn-danger btn-sm"/>
                                    </form>
                                </td>
                            </tr>
                         @endforeach

                    </tbody>

                </table>

            @else

                <div class="invoice-empty">

                    <p class="invoice-empty-title">No invoices were created</p>
                    <a href="{{route('invoices.create')}}" class="btn btn-success pull-right">Create Now</a>
                </div>


            @endif

        </div>

    </div>

@endsection