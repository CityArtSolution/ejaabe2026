<div class="form-group">
    <label class="input-label font-weight-500">{{ trans('site.captcha') }}</label>
    <div class="row align-items-center">
        <div class="col">
            <input type="text" name="captcha" class="form-control @error('captcha')  is-invalid @enderror">
            @error('captcha')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col d-flex align-items-center" style="min-width: 0;">
            <img id="captchaImageComment" class="captcha-image" src="" style="min-width: 0; max-width: calc(100% - 40px); height: auto;">

            <button type="button" id="refreshCaptcha" class="btn-transparent ml-15">
                <i data-feather="refresh-ccw" width="24" height="24" class=""></i>
            </button>
        </div>
    </div>
</div>
