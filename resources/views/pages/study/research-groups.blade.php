@extends('homepage.two-column-layout')

<?php

$groups = [
	[
		'title' => 'Materials Science',
		'description' => 'The principal aim of the research programme of the Applied Physics-Materials Science group is to search for the relation between the microstructure of materials and its physical properties. The programme concentrates on experimental and theoretical work of the characterization of line defects (dislocations and disclinations) and homo-/heterophase interfaces so as to draw conclusions about the correlation between atomic structure, electronic charge transfer, and physical properties, both structural and functional.',
			'photo' => '/research/zernike/materials-science/2_MK_ZIAMWEB.jpg',	
			'groups' => [
			[
				'group' => 'De Hosson',
				'title' => 'Materials Science',
				'contact' => 'http://www.rug.nl/staff/j.t.m.de.hosson/',
				'link' => 'http://www.rug.nl/research/zernike/materials-science/de-hosson-group/',
				'foto' => '/research/zernike/people/DeHosson-1-WEB.jpg'
			]
			]
	],
	
	[
		'title' => 'Micromechanics',
		'description' => 'The mission of this research group is to develop new models and computational tools for the micromechanics of materials, and to employ these to develop relationships between the internal structure of a material and its mechanical properties. We study material properties at a range of length scales, placing special emphasis on scale transitions. We cover a variety of engineering materials, considering and exploiting the similarities and differences in their behaviour.',
			'photo' => '/research/zernike/micromechanics/MiMec_small.jpg',	
			'groups' => [
			[
				'group' => 'Van der Giessen',
				'title' => 'Micromechanics of Materials',
				'contact' => 'http://www.rug.nl/staff/e.van.der.giessen/',
				'link' => 'http://www.rug.nl/research/zernike/micromechanics/van-der-giessen-group/',
				'foto' => '/research/zernike/people/VanderGiessen-1-WEB.jpg'
			],
			[
				'group' => 'Onck',
				'title' => 'Micromechanics of Cellular and Active Materials',
				'contact' => 'http://www.rug.nl/staff/p.r.onck/',
				'link' => 'http://www.rug.nl/research/zernike/micromechanics/onck-group/',
				'foto' => '/research/zernike/people/Onck-1.jpg'
			]
			]
	],

	[
		'title' => 'Nanostructured Materials and Interfaces',
		'description' => 'Investigating the relation between nanostructure and functional properties of materials. Our research focus is on material structures, surfaces/interfaces, and surface interactions at the nanoscale. Our research interests include phase change materials, nanoclusters/nanoparticles, nanoresonators, surface forces, friction, and adhesion. Experimental facilities include scanning probe, scanning electron, and Transmission electron microscopy. Applications of our research are connected with hydrogen storage, novel NEMS devices and phase change memories.',
			'photo' => '/research/zernike/nanostructured-materials-and-interfaces/NMI_group.jpg',	
			'groups' => [
			[
				'group' => 'Kooi',
				'title' => 'Nanostructured Materials and Interfaces',
				'contact' => 'http://www.rug.nl/staff/b.j.kooi/',
				'link' => 'http://www.rug.nl/research/zernike/nanostructured-materials-and-interfaces/kooi-group/',
				'foto' => '/research/zernike/people/Kooi-1-WEB.jpg'
			],
			[
				'group' => 'Palasantzas',
				'title' => 'Surface Interactions and Nanostructures',
				'contact' => 'http://www.rug.nl/staff/g.palasantzas/',
				'link' => 'http://www.rug.nl/research/zernike/nanostructured-materials-and-interfaces/palasantzas-group/',
				'foto' => '/research/zernike/people/Palasantzas-1-WEB.jpg'
			]
			]
	],

	[
		'title' => 'Photophysics and Opto-electronics',
		'description' => 'Our group aims to develop novel materials for solar cell & microelectronics applications. The materials we work on have in common that they are solution processable. This property holds the promise of cheap production methods with a low energy demand. Our research focusses on a number of subjects:<ul><li>The properties of organic semiconductors and organic/organic interfaces and their application in optoelectronic devices</li><li>Physical and optoelectronic properties of carbon nanotubes and hybrids systems</li><li>Fabrication of hybrid optoelectronic devices composed by inorganic nanocrystals and organic molecules</li></ul>',
			'photo' => '/research/zernike/photophysics-and-opto-electronics/images/PbS-CdS_Coreshell_quantumdots.png',	
			'groups' => [
			[
				'group' => 'Loi',
				'title' => 'Materials for Solar Cell & Microelectronics Applications',
				'contact' => 'http://www.rug.nl/staff/m.a.loi/',
				'link' => 'http://www.rug.nl/research/zernike/photophysics-and-opto-electronics/loi-group/',
				'foto' => '/research/zernike/photophysics-and-opto-electronics/loi-group/images/employees/Maria_Loi_2.jpg'
			],
			[
				'group' => 'Koster',
				'title' => 'Device Physics of Organic Semiconductors',
				'contact' => 'http://www.rug.nl/staff/l.j.a.koster/',
				'link' => 'http://www.rug.nl/research/zernike/photophysics-and-opto-electronics/koster-group/',
				'foto' => '/research/zernike/photophysics-and-opto-electronics/images/Jan_Anton_Koster_2.jpg'
			]
			]
	],

	[
		'title' => 'Device Physics of Complex Materials',
		'description' => 'Device physics contributes to our present knowledge of emergent behaviour of complex materials and probes its properties by making use of modern experimental tools and techniques based on nanotechnology. Emergent behaviour is prevalent in many complex materials and originates from competing interactions of electronic, magnetic and structural origin.',
			'photo' => '/research/zernike/device-physics-of-complex-materials/ye-group/YeWeb_460.png',	
			'groups' => [
			[
				'group' => 'Ye',
				'title' => 'Device Physics of Complex Materials',
				'contact' => 'http://www.rug.nl/staff/j.ye/',
				'link' => 'http://www.rug.nl/research/zernike/device-physics-of-complex-materials/ye-group/',
				'foto' => '/research/zernike/people/Ye-1-WEB.jpg'
			]
			]
	],

	[
		'title' => 'Physics of Nanodevices',
		'description' => 'We explore new physical phenomena that occur in electronic and opto-electronic device structures with nanoscale dimensions. The dynamics of such devices is often quantum mechanical in nature, but much richer than the dynamics of isolated atoms due to interactions with the solid-state environment. Our research investigates this quantum dynamics, and aims to apply it for new device functionalities.',
			'photo' => '/research/physics-of-nanodevices/nanolab.jpg',	
			'groups' => [
			[
				'group' => 'van Wees',
				'title' => 'Magnon Spintronics in Magnetic Insulators',
				'contact' => 'http://www.rug.nl/staff/b.j.van.wees/',
				'link' => 'http://www.rug.nl/research/zernike/physics-of-nanodevices/research/magnonspintronics',
				'foto' => '/research/zernike/people/VanWees-1-WEB.jpg'
			],

			[
				'group' => 'van der Wal',
				'title' => 'Physics of Quantum Devices',
				'contact' => 'http://www.rug.nl/staff/c.h.van.der.wal/',
				'link' => 'http://www.rug.nl/research/physics-of-nanodevices/research/quantum-devices',
				'foto' => '/research/zernike/people/VanDerWal-1-WEB.jpg'
			],

			[
				'group' => 'Banerjee',
				'title' => 'Spintronics in Functional Materials',
				'contact' => 'http://www.rug.nl/staff/t.banerjee/',
				'link' => 'http://www.rug.nl/research/physics-of-nanodevices/research/spin-transport',
				'foto' => '/research/zernike/people/Banjeree-1-WEB.jpg'
			]
			]
		],
];
?>

@section('content')
    @foreach($groups as $group)
	      @include('pages.study._research-groups', ['group' => $group])
	  @endforeach
@endsection

@section('header-image')
    @component('homepage.header._header_image')
    <div class="header-image__title">
        <h2 class="">
            Research Groups
        </h2>
    </div>
    @endcomponent
@endsection
