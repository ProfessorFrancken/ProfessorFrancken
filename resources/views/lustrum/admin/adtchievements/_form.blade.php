<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="title">Title</label>
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Earn an anytimer from the board', 'id' => 'title']) !!}
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => '', 'id' => 'description']) !!}
        </div>

        <div class="form-group">
            <label for="past_tense">Past tense</label>
            {!! Form::text('past_tense', null, ['class' => 'form-control', 'placeholder' => '', 'id' => 'past_tense']) !!}
        </div>

        <div class="form-group">
            <label for="name">Points</label>
            {!! Form::number('points', null, ['class' => 'form-control', 'placeholder' => '33', 'id' => 'points']) !!}
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('is_repeatable', true, $adtchievement->is_repeatable, ['class' => 'form-check-input', 'id' => 'is_repeatable'])  !!}
            <label class="form-check-label" for="is_repeatable">Is repeatable</label>
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('is_team_effort', true, $adtchievement->is_team_effort, ['class' => 'form-check-input', 'id' => 'is_team_effort'])  !!}
            <label class="form-check-label" for="is_team_effort">Is a team effort</label>
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('is_hidden', true, $adtchievement->is_hidden, ['class' => 'form-check-input', 'id' => 'is_hidden'])  !!}
            <label class="form-check-label" for="is_hidden">Is a hidden adtchievement</label>
        </div>
    </div>
</div>
