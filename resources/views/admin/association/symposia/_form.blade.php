<div class="row mt-4">
    <div class="col">
        <div class="form-group">
            <label for="title">Symposium name</label>
            {!! Form::text('name', null, ['class' => 'form-control symposium-name', 'placeholder' => 'Name', 'id' => 'name']) !!}
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            {!! Form::text('location', null, ['class' => 'form-control symposium-location', 'placeholder' => 'Location']) !!}
        </div>

        <div class="form-group">
            <label for="Webstie url">Website url</label>
            {!! Form::text('website_url', 'https://franckensymposium.nl', ['class' => 'form-control symposium-website-url', 'placeholder' => 'https://franckensymposium.nl']) !!}
        </div>

        <div class="form-group">
            <label for="purchase_date">Start date</label>
            {!! Form::datetime('start_date', optional($symposium->start_date)->format('Y-m-d'), ['class' => 'form-control', 'id' => 'start_date']) !!}
        </div>

        <div class="form-group">
            <label for="purchase_date">End date</label>
            {!! Form::datetime('end_date', optional($symposium->end_date)->format('Y-m-d'), ['class' => 'form-control', 'id' => 'end_date']) !!}
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('open_for_registration', true, $symposium->open_for_registration, ['class' => 'form-check-input', 'id' => 'open_for_registration'])  !!}
            <label class="form-check-label" for="open_for_registration">Open for registration</label>
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('promote_on_agenda', true, $symposium->promote_on_agenda, ['class' => 'form-check-input', 'id' => 'promote_on_agenda'])  !!}
            <label class="form-check-label" for="promote_on_agenda">Promote on agenda</label>
        </div>

    </div>
</div>
