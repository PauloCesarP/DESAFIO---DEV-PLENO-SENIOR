@extends('master')

@section('title')
    <title>Título da página</title>
@endsection

@section('content')
    <div class="container">
        <h1 class="text-primary mb-3 mt-3">Leitor de XML</h1>
        <hr>

        @if (session('message'))
            <div class="alert alert-danger" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <p>XML:</p>
        <div class="">
            <form action="{{ route('readXml') }}" method="POST" enctype="multipart/form-data" id="formXml">
                @csrf
                <input type="file" class="" name="customFile" id="customFile">
                <button class="btn btn-primary" id="sendButton" type="submit">Enviar</button>
                <p>
                    <label>É aceito apenas arquivos XML.</label>
                </p>
            </form>
        </div>
        <hr>
        
        <div id="resultTable">
            <input type="text" name="" id="searchInput" placeholder="Buscar..." class="d-none col-md-12 form-control mb-2">
            <table id="table" class='table table-striped d-none'>
                <thead>
                    <tr>
                        <th scope='col'>Caminho</th>
                        <th scope='col'>Valor</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')

{{-- YOU CAN INSERT YOUR CUSTOM CSS HERE --}}

@endsection

@section('js')

    {{-- YOU CAN INSERT YOUR CUSTOM JS HERE --}}

    <script>

        //CODE RESPONSIBLE FOR RECEIVE THE XML FROM BACKEND AND CONVERT INTO ARRAY WITH KEYS
        let data = <?php echo json_encode($xmlData); ?>;
        dataArray =[];        
        for(key in data){dataArray.push({'key': key, 'value': data[key]})}; 

        //SHOW TABLE IF EXISTS ANY DATA
        if (dataArray.length != 0) {
            $("#table").removeClass('d-none');
            $("#searchInput").removeClass('d-none');
        }    

        //ADD DATA ON TABLE
        dataArray.forEach(array => {
            if(array.value != ''){
                $("#tableBody").append(`
                    <tr>
                        <td class="font-weight-bold">${array.key}</td>
                        <td class="col text-break">${array.value}</td>                       
                    </tr>
                `);
            }
        });

        //FUNCTION RESPONSIBLE FOR SEARCH IN THE TABLE
        $($("#searchInput")).keyup(function (e) {

            let rows = $('#tableBody tr');
            let searchTerm = this.value;

            for(let position in rows){
                if (true === isNaN(position)) {
                    continue;
                }
            
                let rowContent = rows[position].innerHTML;

                if(true === rowContent.includes(searchTerm)){
                    rows[position].style.display = '';
                } else {
                    rows[position].style.display = 'none';
                }
            }
        });

    </script>

@stop
