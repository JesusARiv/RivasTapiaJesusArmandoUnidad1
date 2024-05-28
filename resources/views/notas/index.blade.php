@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (count($notas))
                    @foreach ($notas as $nota)
                        <div class="card mb-3">
                            <div class="card-header">{{ $nota->titulo }}</div>
                            <div class="card-body">
                                {{ $nota->nota }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card">
                        <div class="card-header">No existen</div>
                        <div class="card-body">
                            Aún no hay notas
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <button class="btn btn-success" id="agregar">Agregar nota</button>
            </div>
        </div>
    </div>
    <form method="POST" id="registroNotaForm" class="needs-validation" novalidate>
        @csrf
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('agregar').addEventListener('click', function() {
                const miForm = document.getElementById('registroNotaForm');
                Swal.fire({
                    'title': 'Nueva Nota',
                    'html': `<input type="text" class="swal2-input mx-0" form="registroNotaForm" required placeholder="Titulo" name="titulo">
                <br><input type="text" class="swal2-input mx-0" form="registroNotaForm" required placeholder="Escribe tu nota" name="nota">`,
                    'focusConfirm': false,
                    'preConfirm': function() {
                        miForm.classList.add('was-validated');
                        miForm.reportValidity();
                        return miForm.checkValidity();
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        fetch(location.href, {
                            method: 'POST',
                            contentType: 'application/json',
                            body: new FormData(miForm)
                        }).then(function(result) {
                            if (result.ok) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    'title': 'error',
                                    'icon': 'error',
                                    'text': 'ocurrio un error'
                                })
                            }
                        })
                    }
                })
            })
        });
    </script>
@endsection
