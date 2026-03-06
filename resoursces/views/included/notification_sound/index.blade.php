<div class="col-xl-6">
    <div class="form-group last">
        <label class="form-label" for="notification_sound">{{ trans('labels.notification_sound') }}(mp3)</label>
        <input type="file" id="notification_sound" class="form-control" name="notification_sound" accept="audio/mp3">
        @if (!empty($providerdata->notification_sound) && $providerdata->notification_sound != null)
            <audio controls class="mt-2">
                <source src="{{ url(env('ASSETSPATHURL') . 'notification/' . $providerdata->notification_sound) }}"
                    type="audio/mpeg">
            </audio>
        @endif
    </div>
</div>
