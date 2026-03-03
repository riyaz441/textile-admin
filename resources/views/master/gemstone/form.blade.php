@extends('layouts.master')
@section('title', isset($gemstone) ? 'Edit Gemstone - ' . env('APP_NAME') : 'Add Gemstone - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($gemstone) ? 'Edit Gemstone' : 'Add New Gemstone' }}</h5>
                        <button type="button" class="btn btn-secondary"
                            onclick="location.href='{{ route('gemstones.index') }}'">
                            Back to Gemstones
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gemstones.save', $gemstone->gemstone_id ?? null) }}" method="POST">
                            @csrf
                            <h6 class="mt-3 mb-2 text-primary">Basic Information</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="company_id">Company <span class="text-danger">*</span></label>
                                    @php
                                        $companyLocked = isset($selectedCompanyId) && $selectedCompanyId !== 'all';
                                        $companyValue = $companyLocked
                                            ? $selectedCompanyId
                                            : old('company_id', isset($gemstone) ? $gemstone->company_id : '');
                                    @endphp
                                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id"
                                        name="company_id" {{ $companyLocked ? 'disabled' : '' }} required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->company_id }}"
                                                {{ (string) $companyValue === (string) $company->company_id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($companyLocked)
                                        <input type="hidden" name="company_id" value="{{ $companyValue }}">
                                    @endif
                                    @error('company_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="branch_id">Branch <span class="text-danger">*</span></label>
                                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id"
                                        name="branch_id" data-selected="{{ old('branch_id', isset($gemstone) ? $gemstone->branch_id : '') }}" required>
                                        <option value="">Select Branch</option>
                                    </select>
                                    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="gemstone_name">Gemstone Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('gemstone_name') is-invalid @enderror" id="gemstone_name" name="gemstone_name" placeholder="Enter gemstone name" value="{{ old('gemstone_name', isset($gemstone) ? $gemstone->gemstone_name : '') }}" required>
                                    @error('gemstone_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="gemstone_code">Gemstone Code</label>
                                    <input type="text" class="form-control @error('gemstone_code') is-invalid @enderror" id="gemstone_code" name="gemstone_code" placeholder="Enter gemstone code" value="{{ old('gemstone_code', isset($gemstone) ? $gemstone->gemstone_code : '') }}">
                                    @error('gemstone_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="diamond" {{ old('type', isset($gemstone) ? $gemstone->type : '') == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                        <option value="ruby" {{ old('type', isset($gemstone) ? $gemstone->type : '') == 'ruby' ? 'selected' : '' }}>Ruby</option>
                                        <option value="sapphire" {{ old('type', isset($gemstone) ? $gemstone->type : '') == 'sapphire' ? 'selected' : '' }}>Sapphire</option>
                                        <option value="emerald" {{ old('type', isset($gemstone) ? $gemstone->type : '') == 'emerald' ? 'selected' : '' }}>Emerald</option>
                                        <option value="pearl" {{ old('type', isset($gemstone) ? $gemstone->type : '') == 'pearl' ? 'selected' : '' }}>Pearl</option>
                                        <option value="other" {{ old('type', isset($gemstone) ? $gemstone->type : '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <hr>
                            <h6 class="mt-4 mb-2 text-primary">Quality & Appearance</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="color">Color</label>
                                    <select class="form-select @error('color') is-invalid @enderror" id="color" name="color">
                                        <option value="">Select Color</option>
                                        <option value="Red" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Red' ? 'selected' : '' }}>Red</option>
                                        <option value="Blue" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Blue' ? 'selected' : '' }}>Blue</option>
                                        <option value="Green" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Green' ? 'selected' : '' }}>Green</option>
                                        <option value="Yellow" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                                        <option value="Pink" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Pink' ? 'selected' : '' }}>Pink</option>
                                        <option value="White" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'White' ? 'selected' : '' }}>White</option>
                                        <option value="Black" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Black' ? 'selected' : '' }}>Black</option>
                                        <option value="Brown" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Brown' ? 'selected' : '' }}>Brown</option>
                                        <option value="Orange" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Orange' ? 'selected' : '' }}>Orange</option>
                                        <option value="Purple" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Purple' ? 'selected' : '' }}>Purple</option>
                                        <option value="Other" {{ old('color', isset($gemstone) ? $gemstone->color : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="clarity">Clarity</label>
                                    <select class="form-select @error('clarity') is-invalid @enderror" id="clarity" name="clarity">
                                        <option value="">Select Clarity</option>
                                        <option value="IF" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'IF' ? 'selected' : '' }}>IF</option>
                                        <option value="VVS1" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'VVS1' ? 'selected' : '' }}>VVS1</option>
                                        <option value="VVS2" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'VVS2' ? 'selected' : '' }}>VVS2</option>
                                        <option value="VS1" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'VS1' ? 'selected' : '' }}>VS1</option>
                                        <option value="VS2" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'VS2' ? 'selected' : '' }}>VS2</option>
                                        <option value="SI1" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'SI1' ? 'selected' : '' }}>SI1</option>
                                        <option value="SI2" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'SI2' ? 'selected' : '' }}>SI2</option>
                                        <option value="I1" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'I1' ? 'selected' : '' }}>I1</option>
                                        <option value="I2" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'I2' ? 'selected' : '' }}>I2</option>
                                        <option value="I3" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'I3' ? 'selected' : '' }}>I3</option>
                                        <option value="Other" {{ old('clarity', isset($gemstone) ? $gemstone->clarity : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('clarity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="default_carat_weight">Default Carat Weight</label>
                                    <input type="number" step="0.001" class="form-control @error('default_carat_weight') is-invalid @enderror"
                                        id="default_carat_weight" name="default_carat_weight" placeholder="Enter carat weight"
                                        value="{{ old('default_carat_weight', isset($gemstone) ? $gemstone->default_carat_weight : '') }}">
                                    @error('default_carat_weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="shape">Shape</label>
                                    <select class="form-select @error('shape') is-invalid @enderror" id="shape" name="shape">
                                        <option value="">Select Shape</option>
                                        <option value="Round" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Round' ? 'selected' : '' }}>Round</option>
                                        <option value="Oval" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Oval' ? 'selected' : '' }}>Oval</option>
                                        <option value="Princess" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Princess' ? 'selected' : '' }}>Princess</option>
                                        <option value="Emerald" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Emerald' ? 'selected' : '' }}>Emerald</option>
                                        <option value="Pear" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Pear' ? 'selected' : '' }}>Pear</option>
                                        <option value="Marquise" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Marquise' ? 'selected' : '' }}>Marquise</option>
                                        <option value="Cushion" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Cushion' ? 'selected' : '' }}>Cushion</option>
                                        <option value="Asscher" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Asscher' ? 'selected' : '' }}>Asscher</option>
                                        <option value="Radiant" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Radiant' ? 'selected' : '' }}>Radiant</option>
                                        <option value="Heart" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Heart' ? 'selected' : '' }}>Heart</option>
                                        <option value="Other" {{ old('shape', isset($gemstone) ? $gemstone->shape : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('shape')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="cut">Cut</label>
                                    <select class="form-select @error('cut') is-invalid @enderror" id="cut" name="cut">
                                        <option value="">Select Cut</option>
                                        <option value="Brilliant" {{ old('cut', isset($gemstone) ? $gemstone->cut : '') == 'Brilliant' ? 'selected' : '' }}>Brilliant</option>
                                        <option value="Step" {{ old('cut', isset($gemstone) ? $gemstone->cut : '') == 'Step' ? 'selected' : '' }}>Step</option>
                                        <option value="Mixed" {{ old('cut', isset($gemstone) ? $gemstone->cut : '') == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                        <option value="Rose" {{ old('cut', isset($gemstone) ? $gemstone->cut : '') == 'Rose' ? 'selected' : '' }}>Rose</option>
                                        <option value="Cabochon" {{ old('cut', isset($gemstone) ? $gemstone->cut : '') == 'Cabochon' ? 'selected' : '' }}>Cabochon</option>
                                        <option value="Other" {{ old('cut', isset($gemstone) ? $gemstone->cut : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('cut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <h6 class="mt-4 mb-2 text-primary">Measurements</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="measurement_length">Length (mm)</label>
                                    <input type="number" step="0.01" class="form-control @error('measurement_length') is-invalid @enderror" id="measurement_length" name="measurement_length" placeholder="Length" value="{{ old('measurement_length', isset($gemstone) ? $gemstone->measurement_length : '') }}">
                                    @error('measurement_length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="measurement_width">Width (mm)</label>
                                    <input type="number" step="0.01" class="form-control @error('measurement_width') is-invalid @enderror" id="measurement_width" name="measurement_width" placeholder="Width" value="{{ old('measurement_width', isset($gemstone) ? $gemstone->measurement_width : '') }}">
                                    @error('measurement_width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="measurement_depth">Depth (mm)</label>
                                    <input type="number" step="0.01" class="form-control @error('measurement_depth') is-invalid @enderror" id="measurement_depth" name="measurement_depth" placeholder="Depth" value="{{ old('measurement_depth', isset($gemstone) ? $gemstone->measurement_depth : '') }}">
                                    @error('measurement_depth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <hr>
                            <h6 class="mt-4 mb-2 text-primary">Additional Details</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="treatment">Treatment</label>
                                    <select class="form-select @error('treatment') is-invalid @enderror" id="treatment" name="treatment">
                                        <option value="">Select Treatment</option>
                                        <option value="None" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Heated" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Heated' ? 'selected' : '' }}>Heated</option>
                                        <option value="Irradiated" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Irradiated' ? 'selected' : '' }}>Irradiated</option>
                                        <option value="Fracture Filled" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Fracture Filled' ? 'selected' : '' }}>Fracture Filled</option>
                                        <option value="Diffused" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Diffused' ? 'selected' : '' }}>Diffused</option>
                                        <option value="Laser Drilled" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Laser Drilled' ? 'selected' : '' }}>Laser Drilled</option>
                                        <option value="Bleached" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Bleached' ? 'selected' : '' }}>Bleached</option>
                                        <option value="Dyed" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Dyed' ? 'selected' : '' }}>Dyed</option>
                                        <option value="Other" {{ old('treatment', isset($gemstone) ? $gemstone->treatment : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('treatment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="origin">Origin</label>
                                    <input type="text" class="form-control @error('origin') is-invalid @enderror" id="origin" name="origin" placeholder="Enter origin" value="{{ old('origin', isset($gemstone) ? $gemstone->origin : '') }}">
                                    @error('origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="fluorescence">Fluorescence</label>
                                    <select class="form-select @error('fluorescence') is-invalid @enderror" id="fluorescence" name="fluorescence">
                                        <option value="">Select Fluorescence</option>
                                        <option value="None" {{ old('fluorescence', isset($gemstone) ? $gemstone->fluorescence : '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Faint" {{ old('fluorescence', isset($gemstone) ? $gemstone->fluorescence : '') == 'Faint' ? 'selected' : '' }}>Faint</option>
                                        <option value="Medium" {{ old('fluorescence', isset($gemstone) ? $gemstone->fluorescence : '') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="Strong" {{ old('fluorescence', isset($gemstone) ? $gemstone->fluorescence : '') == 'Strong' ? 'selected' : '' }}>Strong</option>
                                        <option value="Very Strong" {{ old('fluorescence', isset($gemstone) ? $gemstone->fluorescence : '') == 'Very Strong' ? 'selected' : '' }}>Very Strong</option>
                                        <option value="Other" {{ old('fluorescence', isset($gemstone) ? $gemstone->fluorescence : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('fluorescence')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="symmetry">Symmetry</label>
                                    <select class="form-select @error('symmetry') is-invalid @enderror" id="symmetry" name="symmetry">
                                        <option value="">Select Symmetry</option>
                                        <option value="Excellent" {{ old('symmetry', isset($gemstone) ? $gemstone->symmetry : '') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="Very Good" {{ old('symmetry', isset($gemstone) ? $gemstone->symmetry : '') == 'Very Good' ? 'selected' : '' }}>Very Good</option>
                                        <option value="Good" {{ old('symmetry', isset($gemstone) ? $gemstone->symmetry : '') == 'Good' ? 'selected' : '' }}>Good</option>
                                        <option value="Fair" {{ old('symmetry', isset($gemstone) ? $gemstone->symmetry : '') == 'Fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="Poor" {{ old('symmetry', isset($gemstone) ? $gemstone->symmetry : '') == 'Poor' ? 'selected' : '' }}>Poor</option>
                                        <option value="Other" {{ old('symmetry', isset($gemstone) ? $gemstone->symmetry : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('symmetry')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="polish">Polish</label>
                                    <select class="form-select @error('polish') is-invalid @enderror" id="polish" name="polish">
                                        <option value="">Select Polish</option>
                                        <option value="Excellent" {{ old('polish', isset($gemstone) ? $gemstone->polish : '') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="Very Good" {{ old('polish', isset($gemstone) ? $gemstone->polish : '') == 'Very Good' ? 'selected' : '' }}>Very Good</option>
                                        <option value="Good" {{ old('polish', isset($gemstone) ? $gemstone->polish : '') == 'Good' ? 'selected' : '' }}>Good</option>
                                        <option value="Fair" {{ old('polish', isset($gemstone) ? $gemstone->polish : '') == 'Fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="Poor" {{ old('polish', isset($gemstone) ? $gemstone->polish : '') == 'Poor' ? 'selected' : '' }}>Poor</option>
                                        <option value="Other" {{ old('polish', isset($gemstone) ? $gemstone->polish : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('polish')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="girdle">Girdle</label>
                                    <select class="form-select @error('girdle') is-invalid @enderror" id="girdle" name="girdle">
                                        <option value="">Select Girdle</option>
                                        <option value="Thin" {{ old('girdle', isset($gemstone) ? $gemstone->girdle : '') == 'Thin' ? 'selected' : '' }}>Thin</option>
                                        <option value="Medium" {{ old('girdle', isset($gemstone) ? $gemstone->girdle : '') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="Thick" {{ old('girdle', isset($gemstone) ? $gemstone->girdle : '') == 'Thick' ? 'selected' : '' }}>Thick</option>
                                        <option value="Extremely Thin" {{ old('girdle', isset($gemstone) ? $gemstone->girdle : '') == 'Extremely Thin' ? 'selected' : '' }}>Extremely Thin</option>
                                        <option value="Extremely Thick" {{ old('girdle', isset($gemstone) ? $gemstone->girdle : '') == 'Extremely Thick' ? 'selected' : '' }}>Extremely Thick</option>
                                        <option value="Other" {{ old('girdle', isset($gemstone) ? $gemstone->girdle : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('girdle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="culet">Culet</label>
                                    <select class="form-select @error('culet') is-invalid @enderror" id="culet" name="culet">
                                        <option value="">Select Culet</option>
                                        <option value="None" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'None' ? 'selected' : '' }}>None</option>
                                        <option value="Pointed" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'Pointed' ? 'selected' : '' }}>Pointed</option>
                                        <option value="Very Small" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'Very Small' ? 'selected' : '' }}>Very Small</option>
                                        <option value="Small" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'Small' ? 'selected' : '' }}>Small</option>
                                        <option value="Medium" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="Large" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'Large' ? 'selected' : '' }}>Large</option>
                                        <option value="Other" {{ old('culet', isset($gemstone) ? $gemstone->culet : '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('culet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="table_percentage">Table %</label>
                                    <input type="number" step="0.01" class="form-control @error('table_percentage') is-invalid @enderror" id="table_percentage" name="table_percentage" placeholder="Enter table %" value="{{ old('table_percentage', isset($gemstone) ? $gemstone->table_percentage : '') }}">
                                    @error('table_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="depth_percentage">Depth %</label>
                                    <input type="number" step="0.01" class="form-control @error('depth_percentage') is-invalid @enderror" id="depth_percentage" name="depth_percentage" placeholder="Enter depth %" value="{{ old('depth_percentage', isset($gemstone) ? $gemstone->depth_percentage : '') }}">
                                    @error('depth_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <hr>

                            <h6 class="mt-4 mb-2 text-primary">Certification</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="certification_lab">Certification Lab</label>
                                    <input type="text" class="form-control @error('certification_lab') is-invalid @enderror" id="certification_lab" name="certification_lab" placeholder="Enter certification lab" value="{{ old('certification_lab', isset($gemstone) ? $gemstone->certification_lab : '') }}">
                                    @error('certification_lab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="certification_number">Certification Number</label>
                                    <input type="text" class="form-control @error('certification_number') is-invalid @enderror" id="certification_number" name="certification_number" placeholder="Enter certification number" value="{{ old('certification_number', isset($gemstone) ? $gemstone->certification_number : '') }}">
                                    @error('certification_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="certification_date">Certification Date</label>
                                    <input type="date" class="form-control @error('certification_date') is-invalid @enderror" id="certification_date" name="certification_date" value="{{ old('certification_date', isset($gemstone) ? $gemstone->certification_date : '') }}">
                                    @error('certification_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('status', isset($gemstone) ? $gemstone->status : 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', isset($gemstone) ? $gemstone->status : 'Active') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($gemstone) ? 'Update Gemstone' : 'Save Gemstone' }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary ms-2">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
