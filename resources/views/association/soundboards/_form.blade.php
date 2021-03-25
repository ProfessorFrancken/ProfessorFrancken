<div class="row">
    <div class="col-3">
        <div class="d-flex flex-column justify-content-end h-100">
            <div>
                <img
                    id="sound-image"
                    alt="Image for the sound"
                    src="{{ optional($sound)->image }}"
                    class="mb-3 img-fluid rounded"
                    style="object-fit: cover"
                />
            </div>

            <x-forms.image-upload
                name="image"
                label="Upload image"
                output-image-id="sound-image"
            />
        </div>
    </div>
    <div class="col">
        <x-forms.file name="audio" label="Audio file" :required="$sound === null" />
        <x-forms.text name="name" label="Name" placeholder="Bestuuuuur" />
        <x-forms.text name="css_background" label="Background color" placeholder="#000000" type="color"/>
        <x-forms.text name="css_foreground" label="Foreground color" placeholder="#ffffff"  type="color"/>
    </div>
</div>
