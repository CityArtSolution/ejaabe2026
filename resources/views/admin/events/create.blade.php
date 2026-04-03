@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($event) ?trans('/admin/main.edit'): trans('admin/main.new') }} </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('events.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ getAdminPanelUrl() }}/events">{{ trans('events.events') }}</a>
                </div>
                <div class="breadcrumb-item">{{!empty($event) ?trans('/admin/main.edit'): trans('events.new') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           
                            <form action="{{ getAdminPanelUrl() }}/events/{{ !empty($event) ? $event->id.'/update' : 'store' }}"
                                  method="Post">
                                @csrf 

                                @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($event) ? 'js-edit-content-locale' : '' }}">
                                            @foreach($userLanguages as $lang => $language)
                                                <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                            @endforeach
                                        </select>
                                        @error('locale')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                @else
                                    <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                @endif

                                <div class="form-group">
                                    <label>{{ trans('events.title') }}</label>
                                    <input type="text" name="title"
                                           class="form-control  @error('title') is-invalid @enderror"
                                           value="{{ !empty($event) ? $event->title : old('title') }}"
                                           placeholder="{{ trans('events.title') }}" required/>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
  <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.thumbnail_image') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text admin-file-manager" data-input="image" data-preview="holder">
                                                            <i class="fa fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="image" id="image" value="{{ !empty($event) ? $event->image : old('image') }}" class="form-control @error('image')  is-invalid @enderror"/>
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text admin-file-view" data-input="image">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('image')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                <div class="form-group">
                                    <label>{{ trans('events.location') }}</label>
                                    <input type="text" name="location"
                                           class="form-control  @error('location') is-invalid @enderror"
                                           value="{{ !empty($event) ? $event->location : old('location') }}" required/>
                                    @error('location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
<div class="form-group">
 
    <label class="mb-3">{{ trans('events.what_you_will_learn') }}</label>
    <div id="what_you_will_learn_list">
        @if(!empty($event) && $event->what_you_will_learn)
           @foreach(json_decode($event->what_you_will_learn, true) as $item)

                <div class="input-group mb-2">
                    <input type="text" name="what_you_will_learn[]" 
                           class="form-control @error('what_you_will_learn.*') is-invalid @enderror"
                           value="{{ $item }}" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this)">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="input-group mb-2">
                <input type="text" name="what_you_will_learn[]" 
                       class="form-control @error('what_you_will_learn.*') is-invalid @enderror"
                       required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this)">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
    <button type="button" class="btn btn-success btn-sm mt-2" onclick="addLearnItem()">
        <i class="fa fa-plus"></i> {{ trans('events.add_item') }}
    </button>
    @error('what_you_will_learn.*')
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <label class="mb-3">{{ trans('events.event_content') }}</label>
    <div id="event_content_list">
        @if(!empty($event) && $event->event_content)
                     @foreach(json_decode($event->event_content, true) as $content)

                <div class="input-group mb-2">
                    <input type="text" name="event_content[]" 
                           class="form-control @error('event_content.*') is-invalid @enderror"
                           value="{{ $content }}" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this)">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="input-group mb-2">
                <input type="text" name="event_content[]" 
                       class="form-control @error('event_content.*') is-invalid @enderror"
                       required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this)">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
    <button type="button" class="btn btn-success btn-sm mt-2" onclick="addContentItem()">
        <i class="fa fa-plus"></i> {{ trans('events.add_item') }}
    </button>
    @error('event_content.*')
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="form-group">
    <label class="mb-3">{{ trans('events.details') }}</label>
    <div id="details_list">
        @if(!empty($event) && !empty($event->details))
           
           <div class="input-group mb-2">
                <textarea class="form-control" name="details">{{$event->details ?? ""}}</textarea>
                
              
            </div>
           
        @else
            <div class="input-group mb-2">
                <textarea class="form-control" name="details"></textarea>
                
              
            </div>
        @endif
    </div>
    
    @error('details.*')
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>

 <div class="form-group">
            <label>{{ trans('events.start_date') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
                <input type="date" name="start_date"
                       class="form-control @error('start_date') is-invalid @enderror"
                       value="{{ !empty($event) ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') : old('start_date') }}"
                       required>
                @error('start_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
           
        <div class="form-group">
            <label>{{ trans('events.end_date') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
                <input type="date" name="end_date"
                       class="form-control @error('end_date') is-invalid @enderror"
                       value="{{ !empty($event) ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') : old('end_date') }}"
                       required>
                @error('end_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        
          <div class="form-group">
            <label>{{ trans('events.time') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-clock"></i>
                    </span>
                </div>
                <input type="time" name="time"
                       class="form-control @error('time') is-invalid @enderror"
                       value="{{ !empty($event) ? $event->time : old('time') }}"
                       required>
                @error('time')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        
           <div class="form-group">
            <label>{{ trans('events.price') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        {{ $currency ?? 'ر.س' }}
                    </span>
                </div>
                <input type="number" name="price" step="0.01" min="0"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ !empty($event) ? $event->price : old('price', 0) }}"
                       required>
                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        
        
        <div class="form-group">
            <label>{{ trans('events.number_of_places') }}</label>
            <div class="input-group">
                
                <input type="number" name="number_of_places"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ !empty($event) ? $event->number_of_places : old('number_of_places', 0) }}"
                       >
                @error('number_of_places')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    
    
                              

                                <div class="form-group">
                                    <label for="status">{{ trans('admin/main.status') }}</label>
<select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
    <option disabled selected>{{ trans('admin/main.select_status') }}</option>
    <option value="1" {{ (old('status', !empty($event) ? $event->status : '') == 1) ? 'selected' : '' }}>
        {{ trans('events.enabled') }}
    </option>
    <option value="0" {{ (old('status', !empty($event) ? $event->status : '') == 0) ? 'selected' : '' }}>
        {{ trans('events.disabled') }}
    </option>
</select>
@error('status')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
                                </div>

                              
                           
                                                    </div>
                                               
                                     
                                </div>

                                <div class="text-right mt-4">
                                    <button class="btn btn-primary">{{ trans('events.submit') }}</button>
                                </div>
                            </form>

                       

                        </div>
                    </div>
                    
                    
                    
                    
                    <div class="row">
   


</div>


                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script src="/assets/default/js/admin/categories.min.js"></script>
    
    <script>
function addLearnItem() {
    const container = document.getElementById('what_you_will_learn_list');
    addItem(container, 'what_you_will_learn[]');
}

function addContentItem() {
    const container = document.getElementById('event_content_list');
    addItem(container, 'event_content[]');
}

function addDetailItem() {
  //  const container = document.getElementById('details_list');
  //  addItem(container, 'details[]');
}

function addItem(container, name) {
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="${name}" class="form-control" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this)">
                <i class="fa fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(div);
}

function removeItem(button) {
    const container = button.closest('.input-group');
    if (container.parentElement.children.length > 1) {
        container.remove();
    }
}
</script>
@endpush
