@extends('admin.layouts.app')

@section('title', 'Edit - ' . $consignment->consignment_note_number)
@section('page-title', 'Edit Consignment')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.consignments.index') }}">Consignments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.consignments.show', $consignment->id) }}">{{ $consignment->consignment_note_number }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="callout callout-warning mb-3">
    <h6><i class="fas fa-lock mr-1"></i>Read-Only Fields</h6>
    <small>The <strong>Consignment Note Number</strong> is also used as the <strong>Tracking Number</strong>. It and the <strong>Delivery Status</strong> cannot be changed here. To update status, use the status update panel on the detail page.</small>
</div>

<form action="{{ route('admin.consignments.update', $consignment->id) }}" method="POST" id="editForm">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">

            <!-- Booking Details -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i>Booking Details</h3>
                    <div class="card-tools">
                        <span class="badge badge-light p-2 d-block mb-1">
                            CN: <strong>{{ $consignment->consignment_note_number }}</strong>
                        </span>
                        <span class="badge badge-secondary p-2 d-block">
                            Tracking = CN: <strong>{{ $consignment->tracking_number }}</strong>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Booking Date <span class="text-danger">*</span></label>
                                <input type="text" name="booking_date" id="booking_date"
                                       class="form-control @error('booking_date') is-invalid @enderror"
                                       placeholder="dd/mm/yyyy"
                                       value="{{ old('booking_date', $consignment->booking_date->format('d/m/Y')) }}" required>
                                @error('booking_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Service Mode <span class="text-danger">*</span></label>
                                <select name="service_mode" class="form-control @error('service_mode') is-invalid @enderror" required>
                                    @foreach($serviceModes as $key => $label)
                                        <option value="{{ $key }}" {{ old('service_mode', $consignment->service_mode) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_mode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                       value="{{ old('phone_number', $consignment->phone_number) }}">
                                @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Origin <span class="text-danger">*</span></label>
                                <input type="text" name="origin" class="form-control @error('origin') is-invalid @enderror"
                                       value="{{ old('origin', $consignment->origin) }}" required>
                                @error('origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination <span class="text-danger">*</span></label>
                                <input type="text" name="destination" class="form-control @error('destination') is-invalid @enderror"
                                       value="{{ old('destination', $consignment->destination) }}" required>
                                @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    @if($branches->count() > 0)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Origin Branch</label>
                                <select name="origin_branch_id" class="form-control">
                                    <option value="">-- None --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('origin_branch_id', $consignment->origin_branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ $branch->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination Branch</label>
                                <select name="destination_branch_id" class="form-control">
                                    <option value="">-- None --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('destination_branch_id', $consignment->destination_branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ $branch->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Item Description <span class="text-danger">*</span></label>
                        <textarea name="item_description" class="form-control @error('item_description') is-invalid @enderror"
                                  rows="2" required>{{ old('item_description', $consignment->item_description) }}</textarea>
                        @error('item_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Consigner -->
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-tie mr-2"></i>Consigner Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="consigner_name" class="form-control @error('consigner_name') is-invalid @enderror"
                                       value="{{ old('consigner_name', $consignment->consigner_name) }}" required>
                                @error('consigner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>GST Number</label>
                                <input type="text" name="consigner_gst_number" class="form-control"
                                       value="{{ old('consigner_gst_number', $consignment->consigner_gst_number) }}"
                                       style="text-transform:uppercase">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address </label>
                        <textarea name="consigner_address" class="form-control @error('consigner_address') is-invalid @enderror"
                                  rows="2">{{ old('consigner_address', $consignment->consigner_address) }}</textarea>
                        @error('consigner_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Consignee -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-check mr-2"></i>Consignee Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="consignee_name" class="form-control @error('consignee_name') is-invalid @enderror"
                                       value="{{ old('consignee_name', $consignment->consignee_name) }}" required>
                                @error('consignee_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>GST Number</label>
                                <input type="text" name="consignee_gst_number" class="form-control"
                                       value="{{ old('consignee_gst_number', $consignment->consignee_gst_number) }}"
                                       style="text-transform:uppercase">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="consignee_address" class="form-control @error('consignee_address') is-invalid @enderror"
                                  rows="2">{{ old('consignee_address', $consignment->consignee_address) }}</textarea>
                        @error('consignee_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Weight -->
            <div class="card card-info card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-weight-hanging mr-2"></i>Weight & Package</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>No. of Boxes <span class="text-danger">*</span></label>
                        <input type="number" name="no_of_boxes" class="form-control" min="1"
                               value="{{ old('no_of_boxes', $consignment->no_of_boxes) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Actual Weight (kg) <span class="text-danger">*</span></label>
                        <input type="number" name="actual_weight" class="form-control" min="0" step="0.01"
                               value="{{ old('actual_weight', $consignment->actual_weight) }}" required>
                    </div>
                    <div class="form-group">
                           <label>Chargeable Weight (kg)</label>
                        <input type="number" name="chargeable_weight" class="form-control" min="0" step="0.01"
                               value="{{ old('chargeable_weight', $consignment->chargeable_weight) }}">
                    </div>
                </div>
            </div>

            <!-- Amount -->
            <div class="card card-secondary card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-rupee-sign mr-2"></i>Amount</h3></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Total Amount (₹)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">₹</span></div>
                            <input type="number" name="total_amount" class="form-control" min="0" step="0.01"
                                   value="{{ old('total_amount', $consignment->total_amount) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Grand Total (₹)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">₹</span></div>
                            <input type="number" name="grand_total" class="form-control" min="0" step="0.01"
                                   value="{{ old('grand_total', $consignment->grand_total) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remark -->
            <div class="card card-dark card-outline">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-comment mr-2"></i>Remark</h3></div>
                <div class="card-body">
                    <textarea name="final_remark" class="form-control" rows="3">{{ old('final_remark', $consignment->final_remark) }}</textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-success btn-block btn-lg">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.consignments.show', $consignment->id) }}" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr('#booking_date', {
    dateFormat: 'd/m/Y',
    allowInput: true
});
</script>
@endpush
