<div class="col-6">
    <div class="d-flex flex-column">
        <div class="border-bottom" style="min-width: {{ $chars ?? 35 }}ch; height: 1.75rem">
            {!!  $value ?? "&nbsp;" !!}
        </div>
        <small class="mt-1 text-left text-muted">
            {!! $name !!}
        </small>
    </div>
</div>
