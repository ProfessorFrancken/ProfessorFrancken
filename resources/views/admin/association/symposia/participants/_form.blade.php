<div class="row mt-4">
    <div class="col">
        <div class="form-group">
            <label for="title">Firstname</label>
            {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder' => 'Firstname', 'id' => 'firstname']) !!}
        </div>

        <div class="form-group">
            <label for="title">Lastname</label>
            {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder' => 'lastname', 'id' => 'lastname']) !!}
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('is_nnv_member', true, $participant->is_nnv_member, ['class' => 'form-check-input', 'id' => 'is_nnv_member'])  !!}
            <label class="form-check-label" for="is_nnv_member">Is nnv member</label>
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('is_francken_member', true, $participant->is_francken_member, ['class' => 'form-check-input', 'id' => 'is_francken_member'])  !!}
            <label class="form-check-label" for="is_francken_member">Is Francken member</label>
        </div>

        <div class="form-group form-check">
            <label for="member_id">Francken member id</label>
            {!! Form::number('member_id', null, ['class' => 'form-control', 'id' => 'member_id']) !!}
        </div>

        <div class="form-group form-check">
            <label for="nnv_number">NNV number</label>
            {!! Form::number('nnv_number', null, ['class' => 'form-control', 'id' => 'nnv_number']) !!}
        </div>

        <div class="form-group form-check">
            {!! Form::checkbox('pays_with_iban', true, $participant->pays_with_iban, ['class' => 'form-check-input', 'id' => 'pays_with_iban'])  !!}
            <label class="form-check-label" for="pays_with_iban">Pays with iban</label>
        </div>

        <div class="form-group form-check">
            <label for="iban">IBan</label>
            {!! Form::text('iban', $participant->iban ? decrypt($participant->iban) : '', ['class' => 'form-control', 'id' => 'iban']) !!}
        </div>

    </div>
</div>
