<h3>
    Committee members
</h3>

<ul>
    @foreach ($members as $member)
        <li>
            <h5>
                {{ $member->member->full_name }}
            </h5>
        </li>
    @endforeach
</ul>
<hr/>
