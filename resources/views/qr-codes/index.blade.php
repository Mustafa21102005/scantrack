@extends('layouts.app')

@section('title', 'QR Codes')

@section('content')
    <div class="page-header">
        <h3 class="page-title">QR Codes</h3>
        <x-primary-button href="{{ route('qr-codes.create') }}">Create QR Code</x-primary-button>
    </div>

    <x-success-alert />
    <x-error-alert />

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">QR Codes</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>QR Token</th>
                                    <th>Expire Date</th>
                                    <th>Status</th>
                                    <th>Course</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($qrCodes->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No QR Codes available.</td>
                                    </tr>
                                @else
                                    @foreach ($qrCodes as $qrCode)
                                        <tr>
                                            <td>{{ $qrCode->id }}</td>
                                            <td>
                                                <span class="d-inline-block qr-token"
                                                    data-qr-token="{{ $qrCode->qr_token }}" data-id="{{ $qrCode->id }}"
                                                    style="cursor: pointer; color: red; transition: opacity 0.3s ease-in-out;"
                                                    onclick="toggleQRToken(this, '{{ $qrCode->qr_token }}')">
                                                    ********
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($qrCode->expires_at)->format('d-m-Y H:i') }}</td>
                                            <td>{{ $qrCode->is_active ? 'Active' : 'Expired' }}</td>
                                            <td><a
                                                    href="{{ route('courses.show', $qrCode->course->id) }}">{{ $qrCode->course->title }}</a>
                                            </td>
                                            <td>
                                                @if ($qrCode->is_active)
                                                    <form action="{{ route('qr-codes.expire', $qrCode->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <x-delete-button type="submit">Expire</x-delete-button>
                                                    </form>
                                                    <x-edit-button
                                                        href="{{ route('qr-codes.edit', $qrCode->id) }}">Edit</x-edit-button>
                                                    <a href="#" class="btn btn-inverse-info" data-toggle="modal"
                                                        data-target="#qr-code-modal-{{ $qrCode->id }}">
                                                        Show
                                                    </a>
                                                @endif
                                                @if (!$qrCode->is_active)
                                                    <form action="{{ route('qr-codes.destroy', $qrCode->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-delete-button type="submit">Delete</x-delete-button>
                                                    </form>
                                                @endif

                                                <div class="modal fade" id="qr-code-modal-{{ $qrCode->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="qr-code-modal-title-{{ $qrCode->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="qr-code-modal-title-{{ $qrCode->id }}">
                                                                    QR Code
                                                                </h5>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                {!! QrCode::size(300)->generate(route('qr.scan', $qrCode->qr_token)) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function toggleQRToken(el, token) {
            el.style.opacity = 0;
            setTimeout(() => {
                el.textContent = el.textContent === token ? '********' : token;
                el.style.opacity = 1;
            }, 300);
        }
    </script>
@endsection
