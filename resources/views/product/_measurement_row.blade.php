@php
    $rowIndex = $rowIndex ?? 0;
@endphp
<div class="measurement-template mb-4">
    <div class="card border shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label" for="measurement_id[]">Measurement Type</label>
                    <select class="form-select @error('measurement_id.' . $rowIndex) is-invalid @enderror"
                        name="measurement_id[]">
                        <option value="">Select Type</option>
                        @foreach ($measurementTypes ?? [] as $measurement)
                            <option value="{{ $measurement->measurement_id }}"
                                {{ ($row['measurement_id'] ?? '') == $measurement->measurement_id ? 'selected' : '' }}>
                                {{ $measurement->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('measurement_id.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="unit[]">Unit</label>
                    <input type="text" class="form-control @error('unit.' . $rowIndex) is-invalid @enderror"
                        name="unit[]" placeholder="e.g. mm" value="{{ $row['unit'] ?? '' }}">
                    @error('unit.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="value_decimal[]">Value (Decimal)</label>
                    <input type="number" step="0.01"
                        class="form-control @error('value_decimal.' . $rowIndex) is-invalid @enderror"
                        name="value_decimal[]" placeholder="e.g. 10.50"
                        value="{{ $row['value_decimal'] ?? '' }}">
                    @error('value_decimal.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="value_string[]">Value (String)</label>
                    <input type="text" class="form-control @error('value_string.' . $rowIndex) is-invalid @enderror"
                        name="value_string[]" placeholder="e.g. Medium"
                        value="{{ $row['value_string'] ?? '' }}">
                    @error('value_string.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="position[]">Position</label>
                    <input type="text" class="form-control @error('position.' . $rowIndex) is-invalid @enderror"
                        name="position[]" placeholder="e.g. Top, Side"
                        value="{{ $row['position'] ?? '' }}">
                    @error('position.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label" for="measurement_notes[]">Notes</label>
                    <textarea class="form-control @error('measurement_notes.' . $rowIndex) is-invalid @enderror"
                        name="measurement_notes[]" rows="2"
                        placeholder="Additional notes">{{ $row['measurement_notes'] ?? '' }}</textarea>
                    @error('measurement_notes.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-measurement">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>
