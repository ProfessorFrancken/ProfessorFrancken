<div class="ribbon my-5">
    <div class="container">
        <h2 class="ribbon__header">
            The latest news
        </h2>

        <div class="ribbon__items row align-items-stretch">
            @component('homepage._news-item')
                @slot('title')
                    Experiences of a freshmen
                @endslot

                @slot('date')
                    12 nov 2016
                @endslot


                @slot('author')
                    Mark Boer
                @endslot

                Enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat odio facilisis mauris sit amet massa.
            @endcomponent

            @component('homepage._news-item')
                @slot('title')
                    Experiences of a freshmen
                @endslot

                @slot('date')
                    12 nov 2016
                @endslot


                @slot('author')
                    Mark Boer
                @endslot

                At consectetur lorem donec massa sapien, faucibus et molestie ac, feugiat sed lectus vestibulum mattis ullamcorper velit! Nunc sed augue lacus, viverra vitae congue eu, consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus!
            @endcomponent

            @component('homepage._news-item')
                @slot('title')
                    Experiences of a freshmen
                @endslot

                @slot('date')
                    12 nov 2016
                @endslot


                @slot('author')
                    Mark Boer
                @endslot

                Tellus elementum sagittis vitae et leo duis ut? Phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla facilisi cras fermentum, odio eu feugiat pretium, nibh ipsum consequat nisl.
            @endcomponent
        </div>
        <div class="text-md-right">
            <a class="link-to-all arrow" href="">
                View all news
            </a>
        </div>
    </div>
</div>
