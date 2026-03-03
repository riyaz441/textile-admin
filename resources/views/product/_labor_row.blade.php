@php
    $rowIndex = $rowIndex ?? 0;
@endphp
<div class="labor-template mb-4">
    <div class="card border shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label" for="labor_type_id[]">Labor Type</label>
                    <select class="form-select @error('labor_type_id.' . $rowIndex) is-invalid @enderror"
                        name="labor_type_id[]">
                        <option value="">Select Labor Type</option>
                        @foreach ($laborTypes ?? [] as $type)
                            <option value="{{ $type->labor_id }}"
                                {{ ($row['labor_type_id'] ?? '') == $type->labor_id ? 'selected' : '' }}>
                                {{ $type->labor_name }}</option>
                        @endforeach
                    </select>
                    @error('labor_type_id.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="labor_quantity[]">Quantity</label>
                    <input type="number"
                        class="form-control @error('labor_quantity.' . $rowIndex) is-invalid @enderror"
                        name="labor_quantity[]" placeholder="e.g. 1"
                        value="{{ $row['labor_quantity'] ?? 1 }}">
                    @error('labor_quantity.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="labor_actual_hours[]">Actual Hours</label>
                    <input type="number" step="0.01"
                        class="form-control @error('labor_actual_hours.' . $rowIndex) is-invalid @enderror"
                        name="labor_actual_hours[]" placeholder="e.g. 2.50"
                        value="{{ $row['labor_actual_hours'] ?? '' }}">
                    @error('labor_actual_hours.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="labor_cost_amount[]">Labor Cost</label>
                    <input type="number" step="0.01"
                        class="form-control @error('labor_cost_amount.' . $rowIndex) is-invalid @enderror"
                        name="labor_cost_amount[]"
                        placeholder="e.g. 120.00"
                        value="{{ $row['labor_cost_amount'] ?? '' }}">
                    @error('labor_cost_amount.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label" for="labor_notes[]">Notes</label>
                    <textarea class="form-control @error('labor_notes.' . $rowIndex) is-invalid @enderror"
                        name="labor_notes[]" rows="2" placeholder="Notes (optional)">{{ $row['labor_notes'] ?? '' }}</textarea>
                    @error('labor_notes.' . $rowIndex)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-labor">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>
