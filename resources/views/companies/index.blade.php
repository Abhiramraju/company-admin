@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Companies
                    <a href="{{ route('companies.create') }}" class="btn btn-sm btn-primary float-right">Add Company</a>
                    @if(Session::get('success'))
            <div class="alert alert-success text-center">
              {{Session::get('success')}}
            </div>
            @endif
        </div>
                <div class="card-body">
                <table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Logo</th>
            <th>Website</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->email }}</td>
            <td>
                @if($company->logo)
                    <img src="{{ asset('storage/logos/'.$company->logo) }}" alt="{{ $company->name }}" class="img-thumbnail">
                @endif
            </td>
            <td>{{ $company->website }}</td>
            <td>
                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this company?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Company Modal -->
<div class="modal fade" id="deleteCompanyModal" tabindex="-1" role="dialog" aria-labelledby="deleteCompanyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="deleteCompanyForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCompanyModalLabel">Delete Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this company?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('companies.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'logo', name: 'logo', orderable: false, searchable: false},
                {data: 'website', name: 'website'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Delete Company
        $('body').on('click', '.deleteCompany', function () {
            var company_id = $(this).data("id");
            var url = "{{ route('companies.destroy', ':id') }}";
            url = url.replace(':id', company_id);
            $("#deleteCompanyForm").attr('action', url);
        });
    });
</script>
@endsection
