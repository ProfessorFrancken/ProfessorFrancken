@extends('layout.two-column-layout')
@section('title', "Information for international students - T.F.V. 'Professor Francken'")

@php
$breadcrumbs = [
    ['url' => '/study', 'text' => 'Study'],
    ['text' => 'Internationals'],
];
@endphp
@section('content')
    <h1>Information for internationals</h1>
    <p>
        The following information and useful tips for students starting their studies in Groningen were collected by the <a href="/association/committees/intercie" class="font-weight-bold">intercie</a> committee.
    </p>
    <p>
        If you have further questions feel free to contact them at <a href="mailto:intercietfv@gmail.com">intercietfv@gmail.com</a>.
    </p>

    <h2 id="bank-account" class="mb-1 mt-4">Bank account</h2>
    <p class="text-justify">
        To open a bank account just choose a bank, take an appointment and go there to open a bank account, the employees will guide you all the way through the process.
        To open an account all you need is a BSN, an ID, and, if you are under 18, parents consent.
    </p>

    <h2 id="bsn-number" class="mb-1 mt-4">BSN number</h2>
    <p class="text-justify">
        To get a BSN number you have to register at the gemeente, to do that you need to take an appointment and provide some documents.
        You should register within 5 days of moving to the Netherlands and you should provide a valid passport or ID, a rental agreement with a copy of the proof of identity of the owner/main occupant of the house and a birth certificate in english.
        Students from outside the EU can can only register after showing a residence permit or a letter from the IND proving you have applied for one.
    </p>
    <p class="text-justify">
        You will receive a BSN number a couple of weeks after you applied.
    </p>
    <p class="text-justify">
        You can take appointment here: <a href="https://gemeente.groningen.nl/moving-to-the-netherlands" class="font-weight-bold"'>https://gemeente.groningen.nl/moving-to-the-netherlands</a>.
    </p>

    <h2 id="housing" class="mb-1 mt-4">Housing information</h2>
    <p class="text-justify">
        We all know the struggles of finding a decent permanent place to stay in Groningen.
        The housing crisis is not getting any better and we are here to help!
        First, you should check the <a href="https://www.rug.nl/education/international-students/living-in-the-netherlands/" class="font-weight-bold">university website on housing</a> as it refers to a few other useful sites and updates.
        Furhtermore, you can sign up with lefier to get an affordable student room.
        The agency fee is only 30 which is less than most agents charge.
        However, there is a waiting time so keep that in mind.
        The best time to find a place is around December/January.
    </p>
    <p class="text-justify">
        You can check if you’re being overcharged by entering in your room’s information on this website: <a href="http://groningerstudentenbond.nl/en/bereken-of-je-te-veel-huur-betaalt/" class="font-weight-bold">http://groningerstudentenbond.nl/en/bereken-of-je-te-veel-huur-betaalt/</a>.
        For urgent cases: contact one of us through the contact details posted to find a way to arrange another temporary place.
    </p>

    <h2 id="dutch-lessons" class="mb-1 mt-4">Dutch lessons</h2>
    <p class="text-justify">
        Dutch lessons are quite useful to integrate into the Dutch community and culture.
        It is completely covered by the University until the completion of B1.
        However, you need to pay for course material (books) yourself.
        The way the levels go is 0 &lt; A1 &lt; A2 &lt; B1.
        There are many different time slots that range between morning, noon, and evening in which you can pick the most suitable two classes in the week to partake in.
        Each class lasts 2 hours and you're expected to have an attendance of 75% to pass the course.
        You receive no ECTs but you do get a language diploma.
        For your first time, you must go to the  language center (in the city) and talk to the person in charge.
        Lessons are usually held in Harmonie building next to academic building in the city center.
    </p>
    <p>
        All necessary information on <a href="https://www.rug.nl/language-centre/language-courses/dutch/general-skills/" class="font-weight-bold">can be found on the RUG website</a>
    </p>

    <h2 id="introduction-camp" class="mb-1 mt-4">Introduction camp</h2>
    <p class="text-justify">
        Introduction camps are a fun way to make friends within the RUG realm! <a href="https://pienterkamp.nl" class="font-weight-bold">Pienterkamp</a> is the introduction camp for (applied) physics, (applied) mathematics, and astronomy students.
        It is held on the weekend before university starts.
        Lots of social activities are held in teams and you get a chance to familiarise yourself with people from your own study.
    </p>
    <p class="text-justify">
        <a href="https://www.esn.org/" title="Erasmus Student Network" class="font-weight-bold">ESN</a> has an introduction week which is mainly held for internationals.
        Held for a week starting from the weekend before university starts to a few days into the first week of classes.
        Close to a thousand students from different faculties join every year.
        It is a great way to meet internationals within different faculties and get to know Groningen city.
        It gets a little hectic when pub crawling in large groups but people find their way around eventually with different groups.
        More information about esn can be found on <a href="https://www.esn-groningen.nl/">their website</a>.
    </p>
    <p class="text-justify">
        <a href="https://www.keiweek.nl/en/" class="font-weight-bold">KEI week</a> is a splendid 7-day event filled with activities for all students in Groningen to mingle and bond together around the city.
        It's quite similar to the ESN introduction week but this is less internationally themed and is held in the middle of August, before you start worrying about your studies.
        You get two KEI parents who will be responsible for your group. They also try to put you in groups with similar interests.
    </p>
    <p>
        All in all joining an introduction camp is quite a great way to build new bonds in a new city.
    </p>

    <h2 id="health-insurrance" class="mb-1 mt-4">Health insurrance</h2>
    <p class="text-justify">
        If you are from the EU, health insurance will not be a problem, your national insurance will be accepted in the same way as the Dutch national health insurance.
    </p>
    <p class="text-justify">
        If you are not from the EU then <a href="https://www.aonstudentinsurance.com/students/en/" class="font-weight-bold">AON</a>, the health insurance for students abroad, is a good choice.
        AON offers different levels of insurance according to the situation and their website lets you type some information about your needs and it will suggest the best plan for the situation.
        The most expensive is 40 euros a month and covers everything except pre-existing conditions, which is significantly cheaper than the Dutch national health insurance.
    </p>
    <p class="text-justify">
        The <a href="https://www.studentarts.nl/" class="font-weight-bold">student doctor</a> accepts both EU health insurance and AON and it is quite convenient as it is located on campus.
        If you have a (part-time) job, you are obliged to take out a Basic Healthcare insurance.
        Also when you have a paid internship, and you earn more that € 150,- per month and € 1.500,- per year, you should take out a Basic Healthcare insurance.
    </p>

    <h2 id="job-advice" class="mb-1 mt-4">Job advice</h2>
    <p class="text-justify">
        If you work 56 hours a month and you are from the EU, you are entitled to apply for another loan on top of your tuition fee loan and get ~€950 from the Dutch government every month if you show them your paycheck for the 56 hours and your bank bank statement.
        You show them these details in a building located at <a href="https://www.google.com/maps/place/Kempkensberg+12,+9722+TB+Groningen/data=!4m2!3m1!1s0x47c82d54700bdff3:0xd6c015e2e4f2d074?ved=2ahUKEwiu_4mx5sPgAhUGU1AKHQneD6gQ8gEwAHoECAAQAQ" class="font-weight-bold">Kempkensberg 12, 9722 TB</a> and you shall find that you may not need to go every month, so you could go once and claim the last three months and receive a lot of money.
    </p>
    <p class="text-justify">
        Please be aware that you can work if you are not from the eu but it’s a low amount of hours, you have to get special visa requirements and is generally seen as a big hassle, but it is possible.
        You also can’t get any loans from the dutch government in the non eu citizen case even if you work.
    </p>
    <p class="text-justify">
        Working 14 hours a week may not seem like much but it is, however people can and do actually finance their university by themselves like this.
        Please be aware that it is rather difficult to get a job in the Netherlands without speaking Dutch.
        However it is possible to find a job as a food delivery driver, waitor, or pot washer to name a few, without speaking Dutch. <br/>

        Please note that you need special health insurance as you are now a citizen who works, see <a href="https://www.aansprakelijkheidsverzekering.org/eng/compare-liability-insurance/">aansprakelijkheidsverzekering.org</a> for more information.
    </p>

    <h2 id="aclo" class="mb-1 mt-4">Sports membership (ACLO)</h2>
    <p class="text-justify">
        <a href="https://www.aclosport.nl/" class="font-weight-bold">ACLO</a> is the place to go to for any sport related activity.
        You can pay for your membership onto your rug account and for 59.95 you can enrol for several courses ranging from fitness to ballroom dancing.
        For their courses you pay a deposit of 10 and get it back after you’ve completed attendance for 80% of the classes.
        You can also reserve the swimming pool or any of the other courts through their website.
        Find everything ACLO offers on:  <a href="http://www.aclosport.nl/en/">http://www.aclosport.nl/en/</a>.
    </p>

    <h2 id="bikes" class="mb-1 mt-4">Bikes</h2>
    <p class="text-justify">
        You can buy a bike from any bikeshop, Marktplaats or facebook groups or you can pay monthly for a <a href="https://swapfiets.nl/">swapfiet</a>.
        Don’t buy a bike when someone offers you one for very cheap in the city centre, it’s probably stolen.
        You should probably try to get one with with hand breaks because it is easier to use if you never tried using pedal brakes but it it not difficult getting used to it.
        Swapfiets can be more expensive but if some damage happens to the bike it will get replaced or fixed anywhere in the city for free.
        Remember to always have lights if you’re cycling after dark because you could get fined if you don’t (and it's safer!), you can buy lights in most stores like HEMA, Flying Tiger or So Low.
        Watch out for crossings where all the bike traffic lights go green at the same time, you can recognize them by a white sign with green arrows in a square.
    </p>

    <h2 id="dutch-sim" class="mb-1 mt-4">Dutch SIM</h2>
    <p class="text-justify">
        For a SIM just chose a phone company like Vodafone, KPN, Tele2 or other and ask about their phone plans.
        You can either get a prepaid SIM or a subscription, but you need a dutch bank account for the subscription.
        The subscription can either be 1 or 2 years and monthly plans are usually cheaper with the 2 years subscription.
    </p>

    <h2 id="traveling" class="mb-1 mt-4">Transportation</h2>
    <p class="text-justify">
        It’s cheaper to buy an ov chipkaart compared to buying tickets at the train station please note you need a BSN number.
        You can get the OV <a href="https://www.ov-chipkaart.nl/purchase-an-ov-chipkaart.htm" class="font-weight-bold">here</a>.
        A cheap alternative to travel across the country if you're booking in advance is <a href="https://www.vakantieveilingen.nl/winstpakker.html">vakantieveilingen.nl</a>.
    </p>
@endsection

@section('aside')
<div class="agenda">
    <ul class="agenda-list list-unstyled">
        @foreach ([
            ['text' => 'Bank account', 'link' => '#bank-account'],
            ['text' => 'BSN Number', 'link' => '#bsn-number'],
            ['text' => 'Housing information', 'link' => '#housing'],
            ['text' => 'Dutch lessons', 'link' => '#dutch-lessons'],
            ['text' => 'Introduction camp', 'link' => '#introduction-camp'],
            ['text' => 'Health insurrance', 'link' => '#health-insurrance'],
            ['text' => 'Job advice', 'link' => '#job-advice'],
            ['text' => 'Sports membership (ACLO)', 'link' => '#aclo'],
            ['text' => 'Bikes', 'link' => '#bikes'],
            ['text' => 'Dutch SIM', 'link' => '#dutch-sim'],
            ['text' => 'Transportation', 'link' => '#transportation'],
        ] as $item)
            @include('pages.study._internationals-link', $item)
        @endforeach
    </ul>
</div>
@endsection
