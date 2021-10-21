@extends('commons.template_relatorio')

@section('titulo') ITENS REAJUSTADOS @endsection

@section('conteudo')

<table class="table table-hover table-bordered tabela-relatorio myTable">
    <thead>
        <tr>
            <th>Cod</th>
            <th>Item</th>
            <th>Fornecedor</th>
            <th class='center'>Dt. Atualz. Focco</th>
            <th class='center'>Unid. Med.</th>
            
            <th class='center'>Custo Atual</th>
            <th class='center'>Custo Futuro</th>
            <th class='center'>Perc. (%)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($itens as $item)
        <tr>
            <td>{{$item->cod_item}}</td>
            <td>{{$item->desc_tecnica}}</td>
            <td>{{$item->fornecedor}}</td>
            <td class='center'>{{date("d/m/Y", strtotime($item->dt_atualiza))}}</td>
            <td class='center'>{{$item->unid_med}}</td>
            <td class='center'>{{$item->custo_futuro}}</td>
            
            <td class='center'>{{$item->custo}}</td>
            
            <td class='center'>{{$item->perc}}%</td>
        </tr>
        @endforeach
    </tbody>
</table>    
@endsection
