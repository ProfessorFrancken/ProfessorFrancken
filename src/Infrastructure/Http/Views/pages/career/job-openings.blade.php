@extends('pages.career')

@section('content')
  <h1>Job openings</h1>

  @include('pages.career._job-openings-of-company', ['company' => [
      'name' => 'ASML',
      'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/ASML.png',
      'job-openings' => [
          [
              'job' => 'Internship',
              'link' => 'http://www.asml.com/asml/show.do?lang=EN&ctx=32421&ppc=CAM_UGroningen_148'
          ],
          [
              'job' => 'Jobs',
              'link' => 'http://www.asml.com/asml/show.do?lang=EN&ctx=32420&ppc=CAM_UGroningen_149'
          ],
      ]
  ]])

  @include('pages.career._job-openings-of-company', ['company' => [
      'name' => 'De Nederlandsche Bank',
      'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/dnb.png',
      'job-openings' => [
          [
              'job' => 'Meewerkstage voor student econometrie of actuariaat',
              'link' => 'http://www.dnb.nl/werken-bij/stages/dnb333014.jsp'
          ],
          [
              'job' => 'Traineeship in het zenuwcentrum van de economie',
              'link' => 'http://www.dnb.nl/werken-bij/vacatures/connexys-formulieren/dnb339945.jsp'
          ],
          [
              'job' => 'Meewerkstage voor een WO-student met interesse in pensioen en beleid (Solliciteer)',
              'link' => 'http://www.dnb.nl/werken-bij/stages/dnb338052.jsp'
          ],
      ]
  ]])

  @include('pages.career._job-openings-of-company', ['company' => [
      'name' => 'Optiver',
      'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/Optiver.png',
      'job-openings' => [
          [
              'job' => 'Trading Master Class',
              'link' => 'http://www.optiver.com/amsterdam/careers/job-vacancies/details/9381/Trading-Master-Class-2016#.Vw4H4fl95B0'
          ],
          [
              'job' => 'Trader',
              'link' => 'http://www.optiver.com/amsterdam/careers/job-vacancies/details/1461/Trader#.VuQtIeIrI4l'
          ],
          [
              'job' => 'Trade Cycle Analyst (part-time and full-time)',
              'link' => 'http://www.optiver.com/amsterdam/careers/job-vacancies/details/8801/Trade-Cycle-Analyst#.VuQtI-IrI4l'
          ],
          [
              'job' => 'Graduate Software Developer',
              'link' => 'http://www.optiver.com/amsterdam/careers/job-vacancies/details/9281/Graduate-Software-Developer#.Vt7pBvkrLmE'
          ],
          [
              'job' => 'Junior Researcher',
              'link' => 'http://www.optiver.com/amsterdam/careers/job-vacancies/details/5341/Junior-Researcher#.Vt7ovfkrLmE'
          ],
          [
              'job' => 'Junior Risk Manager',
              'link' => 'http://www.optiver.com/amsterdam/careers/job-vacancies/details/8301/Junior-Risk-Manager#.Vt7pZvkrLmE'
          ],
      ]
  ]])

  @include('pages.career._job-openings-of-company', ['company' => [
      'name' => 'shell',
      'logo' => 'http://www.professorfrancken.nl/wordpress/media/images/carriereplaza/shell.png',
      'job-openings' => [
          [
              'job' => 'asset maintenance, reliability and turnaround',
              'link' => 'http://www.professorfrancken.nl/wordpress/media/pdf/r05992-gres-flyers_asset+maintenance_2pp_v1_web.pdf'
          ],
          [
              'job' => 'wells engineering',
              'link' => 'http://www.professorfrancken.nl/wordpress/media/pdf/r06235-gres-flyers_wells+engineering_2pp_awv2.pdf'
          ],
          [
              'job' => 'Rotating Equipment Engineering',
              'link' => 'http://www.professorfrancken.nl/wordpress/media/pdf/R06609-Rotating+Equipment+Engineering_Flyer_AWv2.pdf'
          ],
          [
              'job' => ' Wells Engineering',
              'link' => 'http://www.professorfrancken.nl/wordpress/media/pdf/R05992-GRES-Flyers_Production+Engineering_2pp_v1_Web.pdf'
          ],
          [
              'job' => 'Shell Assessed Internship',
              'link' => 'http://www.shell.nl/nld/aboutshell/careers-tpkg/students-and-graduates/shell-graduate-programme/internship.html'
          ],
      ]
  ]])
@endsection
