@extends('admin.layouts.app')

@section('title', 'New Booking')
@section('page-title', 'New Consignment Booking')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.consignments.index') }}">Consignments</a></li>
    <li class="breadcrumb-item active">New Booking</li>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<form action="{{ route('admin.consignments.store') }}" method="POST" id="bookingForm">
    @csrf

    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">

            <!-- Booking Details -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i>Booking Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Consignment Note Number (CN) <span class="text-danger">*</span></label>
                                <input type="text" name="consignment_note_number"
                                       class="form-control @error('consignment_note_number') is-invalid @enderror"
                                       placeholder="Enter unique CN number (e.g. 00123)"
                                       value="{{ old('consignment_note_number') }}"
                                       style="text-transform:uppercase"
                                       required>
                                @error('consignment_note_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Must be unique. Cannot be changed after saving.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Booking Date <span class="text-danger">*</span></label>
                                <input type="text" name="booking_date" id="booking_date"
                                       class="form-control @error('booking_date') is-invalid @enderror"
                                       placeholder="dd/mm/yyyy"
                                       value="{{ old('booking_date', date('d/m/Y')) }}" required>
                                @error('booking_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Service Mode <span class="text-danger">*</span></label>
                                <select name="service_mode" class="form-control @error('service_mode') is-invalid @enderror" required>
                                    @foreach($serviceModes as $key => $label)
                                        <option value="{{ $key }}" {{ old('service_mode', 'road') === $key ? 'selected' : '' }}>
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
                                       placeholder="Mobile / Phone" value="{{ old('phone_number') }}">
                                @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Origin <span class="text-danger">*</span></label>
                                <input type="text" name="origin" class="form-control @error('origin') is-invalid @enderror"
                                       placeholder="Origin city" value="{{ old('origin') }}" required>
                                @error('origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination <span class="text-danger">*</span></label>
                                <input type="text" name="destination" class="form-control @error('destination') is-invalid @enderror"
                                       placeholder="Destination city" value="{{ old('destination') }}" required>
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
                                    <option value="">-- Select Branch (Optional) --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('origin_branch_id') == $branch->id ? 'selected' : '' }}>
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
                                    <option value="">-- Select Branch (Optional) --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('destination_branch_id') == $branch->id ? 'selected' : '' }}>
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
                                  rows="2" placeholder="Describe the items being shipped" required>{{ old('item_description') }}</textarea>
                        @error('item_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Consigner Details -->
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-tie mr-2"></i>Consigner (Sender) Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consigner Name <span class="text-danger">*</span></label>
                                <input type="text" name="consigner_name" class="form-control @error('consigner_name') is-invalid @enderror"
                                       placeholder="Full name / Company name" value="{{ old('consigner_name') }}" required>
                                @error('consigner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consigner GST Number</label>
                                <input type="text" name="consigner_gst_number" class="form-control @error('consigner_gst_number') is-invalid @enderror"
                                       placeholder="GSTIN (optional)" value="{{ old('consigner_gst_number') }}"
                                       style="text-transform:uppercase">
                                @error('consigner_gst_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Consigner Address</label>
                        <textarea name="consigner_address" class="form-control @error('consigner_address') is-invalid @enderror"
                                  rows="2" placeholder="Full address including city, state, pincode">{{ old('consigner_address') }}</textarea>
                        @error('consigner_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Consignee Details -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-check mr-2"></i>Consignee (Receiver) Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consignee Name <span class="text-danger">*</span></label>
                                <input type="text" name="consignee_name" class="form-control @error('consignee_name') is-invalid @enderror"
                                       placeholder="Full name / Company name" value="{{ old('consignee_name') }}" required>
                                @error('consignee_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consignee GST Number</label>
                                <input type="text" name="consignee_gst_number" class="form-control @error('consignee_gst_number') is-invalid @enderror"
                                       placeholder="GSTIN (optional)" value="{{ old('consignee_gst_number') }}"
                                       style="text-transform:uppercase">
                                @error('consignee_gst_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Consignee Address</label>
                        <textarea name="consignee_address" class="form-control @error('consignee_address') is-invalid @enderror"
                                  rows="2" placeholder="Full address including city, state, pincode">{{ old('consignee_address') }}</textarea>
                        @error('consignee_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-md-4">

            <!-- Weight & Box Details -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-weight-hanging mr-2"></i>Weight & Package</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>No. of Boxes <span class="text-danger">*</span></label>
                        <input type="number" name="no_of_boxes" class="form-control @error('no_of_boxes') is-invalid @enderror"
                               min="1" value="{{ old('no_of_boxes', 1) }}" required>
                        @error('no_of_boxes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Actual Weight (kg) <span class="text-danger">*</span></label>
                        <input type="number" name="actual_weight" class="form-control @error('actual_weight') is-invalid @enderror"
                               min="0" step="0.01" placeholder="0.00" value="{{ old('actual_weight') }}" required>
                        @error('actual_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                           <label>Chargeable Weight (kg)</label>
                        <input type="number" name="chargeable_weight" class="form-control @error('chargeable_weight') is-invalid @enderror"
                               min="0" step="0.01" placeholder="0.00" value="{{ old('chargeable_weight') }}">
                        @error('chargeable_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Amount Details -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-rupee-sign mr-2"></i>Amount Details</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Total Amount (₹)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">₹</span></div>
                            <input type="number" name="total_amount" id="total_amount"
                                   class="form-control @error('total_amount') is-invalid @enderror"
                                   min="0" step="0.01" placeholder="0.00"
                                   value="{{ old('total_amount', 0) }}">
                        </div>
                        @error('total_amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Grand Total (₹)</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">₹</span></div>
                            <input type="number" name="grand_total" id="grand_total"
                                   class="form-control @error('grand_total') is-invalid @enderror"
                                   min="0" step="0.01" placeholder="0.00"
                                   value="{{ old('grand_total', 0) }}">
                        </div>
                        @error('grand_total')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-comment mr-2"></i>Remarks</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label>Final Remark</label>
                        <textarea name="final_remark" class="form-control"
                                  rows="3" placeholder="Any special instructions or notes...">{{ old('final_remark') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="card">
                <div class="card-body">
                    <div class="callout callout-info mb-3">
                        <h6><i class="fas fa-info-circle mr-1"></i>Tracking Number</h6>
                        <small>The <strong>Consignment Note Number</strong> will also be used as the <strong>Tracking Number</strong> for customers.</small>
                    </div>
                    <button type="submit" class="btn btn-success btn-block btn-lg">
                        <i class="fas fa-save mr-2"></i>Create Booking
                    </button>
                    <a href="{{ route('admin.consignments.index') }}" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-times mr-2"></i>Cancel
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
