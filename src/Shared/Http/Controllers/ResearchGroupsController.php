<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class ResearchGroupsController
{
    /**
     * @var string[][][][]|string[][]
     */
    private array $groups;

    public function __construct()
    {
        $this->groups = [
            [
                'title' => 'Computational Physics',
                'description' => 'The mission of the research group Computational Physics is to conduct research in physics through the innovative use of computer and information technology.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_tc-cp.png',
                'groups' => [
                    [
                        'group' => 'De Raedt',
                        'title' => 'Computational Physics',
                        'contact' => 'https://www.rug.nl/research/zernike/computational-physics/de-raedt-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/computational-physics/de-raedt-group/',
                        'foto' => 'https://www.rug.nl/about-us/images_new/topicpage/onderzoek/science-plaatjes/onderzoeker-pc.jpg'
                    ],
                ]
            ],
            [
                'title' => 'Device Physics of Complex Materials',
                'description' => 'Device physics contributes to our present knowledge of emergent behaviour of complex materials and probes its properties by making use of modern experimental tools and techniques based on nanotechnology. Emergent behaviour is prevalent in many complex materials and originates from competing interactions of electronic, magnetic and structural origin.',
                'photo' => 'https://www.rug.nl/research/zernike/device-physics-of-complex-materials/ye-group/YeWeb_460.png',
                'groups' => [
                    [
                        'group' => 'Ye',
                        'title' => 'Device Physics of Complex Materials',
                        'contact' => 'https://www.rug.nl/staff/j.ye/',
                        'link' => 'https://www.rug.nl/research/zernike/device-physics-of-complex-materials/ye-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/Ye-1-WEB.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Materials Science',
                'description' => 'The principal aim of the research programme of the Applied Physics-Materials Science group is to search for the relation between the microstructure of materials and its physical properties. The programme concentrates on experimental and theoretical work of the characterization of line defects (dislocations and disclinations) and homo-/heterophase interfaces so as to draw conclusions about the correlation between atomic structure, electronic charge transfer, and physical properties, both structural and functional.',
                'photo' => 'https://www.rug.nl/research/zernike/materials-science/2_MK_ZIAMWEB.jpg',
                'groups' => [
                    [
                        'group' => 'De Hosson',
                        'title' => 'Materials Science',
                        'contact' => 'https://www.rug.nl/staff/j.t.m.de.hosson/',
                        'link' => 'https://www.rug.nl/research/zernike/materials-science/de-hosson-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/DeHosson-1-WEB.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Micromechanics',
                'description' => 'The mission of this research group is to develop new models and computational tools for the micromechanics of materials, and to employ these to develop relationships between the internal structure of a material and its mechanical properties. We study material properties at a range of length scales, placing special emphasis on scale transitions. We cover a variety of engineering materials, considering and exploiting the similarities and differences in their behaviour.',
                'photo' => 'https://www.rug.nl/research/zernike/micromechanics/MiMec_small.jpg',
                'groups' => [
                    [
                        'group' => 'Van der Giessen',
                        'title' => 'Micromechanics of Materials',
                        'contact' => 'https://www.rug.nl/staff/e.van.der.giessen/',
                        'link' => 'https://www.rug.nl/research/zernike/micromechanics/van-der-giessen-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/VanderGiessen-1-WEB.jpg'
                    ],
                    [
                        'group' => 'Onck',
                        'title' => 'Micromechanics of Cellular and Active Materials',
                        'contact' => 'https://www.rug.nl/staff/p.r.onck/',
                        'link' => 'https://www.rug.nl/research/zernike/micromechanics/onck-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/Onck-1.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Nanostructured Materials and Interfaces',
                'description' => 'Investigating the relation between nanostructure and functional properties of materials. Our research focus is on material structures, surfaces/interfaces, and surface interactions at the nanoscale. Our research interests include phase change materials, nanoclusters/nanoparticles, nanoresonators, surface forces, friction, and adhesion. Experimental facilities include scanning probe, scanning electron, and Transmission electron microscopy. Applications of our research are connected with hydrogen storage, novel NEMS devices and phase change memories.',
                'photo' => 'https://www.rug.nl/research/zernike/nanostructured-materials-and-interfaces/NMI_group.jpg',
                'groups' => [
                    [
                        'group' => 'Kooi',
                        'title' => 'Nanostructured Materials and Interfaces',
                        'contact' => 'https://www.rug.nl/staff/b.j.kooi/',
                        'link' => 'https://www.rug.nl/research/zernike/nanostructured-materials-and-interfaces/kooi-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/Kooi-1-WEB.jpg'
                    ],
                    [
                        'group' => 'Palasantzas',
                        'title' => 'Surface Interactions and Nanostructures',
                        'contact' => 'https://www.rug.nl/staff/g.palasantzas/',
                        'link' => 'https://www.rug.nl/research/zernike/nanostructured-materials-and-interfaces/palasantzas-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/Palasantzas-1-WEB.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Nanostructures of Functional Oxides',
                'description' => 'We investigate materials that display physical phenomena and responses of relevance for electronic applications.
We are particularly interested in ferroelectric, piezoelectric, thermoelectric, ferromagnetics or multiferroic oxides. Our approach consists on exploiting the symmetry-property relationships by achieving a high control of the materials synthesis, combined with a detailed nanoscale structural and physical characterization.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_nfo.jpg',
                'groups' => [
                    [
                        'group' => 'Noheda',
                        'title' => 'Noheda Group',
                        'contact' => 'https://www.rug.nl/research/zernike/nanostructures-of-functional-oxides/contact',
                        'link' => 'https://www.rug.nl/research/zernike/nanostructures-of-functional-oxides/nanostructures-of-functional-oxides',
                        'foto' => 'https://www.rug.nl/research/zernike/people/noheda-1-web-new.jpg'
                    ],
                    [
                        'group' => 'Blake',
                        'title' => 'Blake Group',
                        'contact' => 'https://www.rug.nl/research/zernike/nanostructures-of-functional-oxides/blake-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/nanostructures-of-functional-oxides/blake-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/blake-1-web-new.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Optical Condensed Matter Physics',
                'description' => 'Our aim is to identify, understand, and, if possible, control the nature of various physical phenomena and functionalities of condensed matter systems. We approach this problem using a variety of linear and non-linear optical techniques and by developing microscopic models to describe the observed phenomena.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_ocmp.png',
                'groups' => [
                    [
                        'group' => 'Pchenitchnikov',
                        'title' => 'Pchenitchnikov Group',
                        'contact' => 'https://www.rug.nl/research/zernike/optical-condensed-matter-physics/pchenitchnikov-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/optical-condensed-matter-physics/pchenitchnikov-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/optical-condensed-matter-physics/ocmp_lab-new.jpg'
                    ],
                    [
                        'group' => 'Tobey',
                        'title' => 'Tobey Group',
                        'contact' => 'https://www.rug.nl/research/zernike/optical-condensed-matter-physics/tobey-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/optical-condensed-matter-physics/tobey-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/optical-condensed-matter-physics/tobeylab3-new.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Photophysics and Opto-electronics',
                'description' => 'Our group aims to develop novel materials for solar cell & microelectronics applications. The materials we work on have in common that they are solution processable. This property holds the promise of cheap production methods with a low energy demand. Our research focusses on a number of subjects:<ul><li>The properties of organic semiconductors and organic/organic interfaces and their application in optoelectronic devices</li><li>Physical and optoelectronic properties of carbon nanotubes and hybrids systems</li><li>Fabrication of hybrid optoelectronic devices composed by inorganic nanocrystals and organic molecules</li></ul>',
                'photo' => 'https://www.rug.nl/research/zernike/photophysics-and-opto-electronics/images/PbS-CdS_Coreshell_quantumdots.png',
                'groups' => [
                    [
                        'group' => 'Loi',
                        'title' => 'Materials for Solar Cell & Microelectronics Applications',
                        'contact' => 'https://www.rug.nl/staff/m.a.loi/',
                        'link' => 'https://www.rug.nl/research/zernike/photophysics-and-opto-electronics/loi-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/photophysics-and-opto-electronics/loi-group/images/employees/Maria_Loi_2.jpg'
                    ],
                    [
                        'group' => 'Koster',
                        'group-title' => 'dr.',
                        'title' => 'Device Physics of Organic Semiconductors',
                        'contact' => 'https://www.rug.nl/staff/l.j.a.koster/',
                        'link' => 'https://www.rug.nl/research/zernike/photophysics-and-opto-electronics/koster-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/photophysics-and-opto-electronics/images/Jan_Anton_Koster_2.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Physics of Nanodevices',
                'description' => 'We explore new physical phenomena that occur in electronic and opto-electronic device structures with nanoscale dimensions. The dynamics of such devices is often quantum mechanical in nature, but much richer than the dynamics of isolated atoms due to interactions with the solid-state environment. Our research investigates this quantum dynamics, and aims to apply it for new device functionalities.',
                'photo' => 'https://www.rug.nl/research/zernike/physics-of-nanodevices/nanolab.jpg.jpg',
                'groups' => [
                    [
                        'group' => 'van Wees',
                        'title' => 'Magnon Spintronics in Magnetic Insulators',
                        'contact' => 'https://www.rug.nl/staff/b.j.van.wees/',
                        'link' => 'https://www.rug.nl/research/zernike/physics-of-nanodevices/research/magnonspintronics',
                        'foto' => 'https://www.rug.nl/research/zernike/people/VanWees-1-WEB.jpg'
                    ],

                    [
                        'group' => 'van der Wal',
                        'title' => 'Physics of Quantum Devices',
                        'contact' => 'https://www.rug.nl/staff/c.h.van.der.wal/',
                        'link' => 'https://www.rug.nl/research/physics-of-nanodevices/research/quantum-devices',
                        'foto' => 'https://www.rug.nl/research/zernike/people/VanDerWal-1-WEB.jpg'
                    ],

                    [
                        'group' => 'Banerjee',
                        'title' => 'Spintronics in Functional Materials',
                        'contact' => 'https://www.rug.nl/staff/t.banerjee/',
                        'link' => 'https://www.rug.nl/research/physics-of-nanodevices/research/spin-transport',
                        'foto' => 'https://www.rug.nl/research/zernike/people/Banjeree-1-WEB.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Quantum Interactions and Structural Dynamics',
                'description' => 'Our research efforts focus on the ultrafast processes induced by energetic particle and photon interactions with matter ranging from single atoms and (bio-)molecules via clusters to surfaces. We aim at unveiling <ul><li>the primary electron dynamics occurring on femtosecond timescales and</li><li>the subsequent structural and functional changes.</li></ul>
The knowledge obtained is applied in fields such as nanolithography,  advanced material science, space research, mass spectrometry and radiotherapy.
<br><br>
The research has a strong instrumentation development component. For our experiments with ions we operate the ZERNIKE-LEIF facility centered around our highly-charged ion source. The photon work is performed at synchrotrons or Free Electron Lasers.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_qisd.png',
                'groups' => [

                    [
                        'group' => 'Hoekstra',
                        'title' => 'Experimental Atomic Physics',
                        'contact' => 'https://www.rug.nl/staff/r.a.hoekstra/',
                        'link' => 'https://www.rug.nl/research/zernike/quantum-interactions-and-structural-dynamics/hoekstra-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/hoekstra-1-web-new.jpg'
                    ],

                    [
                        'group' => 'Schlathölter',
                        'title' => 'Gas Phase Biomolecules and Energetic Interactions',
                        'contact' => 'https://www.rug.nl/staff/t.a.schlatholter/',
                        'link' => 'https://www.rug.nl/research/zernike/quantum-interactions-and-structural-dynamics/schlatholter-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/schlatholter-1-web-new.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Solid State Materials for Electronics',
                'description' => 'We investigate the synthesis, crystal structure, and electronic properties of compounds with interesting physical phenomena. We are in particular interested in electrical conduction and dielectric properties of transition metal oxides, and of molecular organic conductors. Both classes of materials not only display a wealth of exciting properties, such as superconductivity, magnetism and ferroelectricity, but are also of relevance for electronic applications.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_ssme.png',
                'groups' => [

                    [
                        'group' => 'Palstra',
                        'title' => 'Solid State Chemistry',
                        'contact' => 'https://www.rug.nl/research/zernike/ssme/palstra-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/ssme/palstra-group/',
                        'foto' => 'https://www.rug.nl/about-us/images_new/topicpage/onderzoek/science-plaatjes/onderzoeker-pc.jpg'
                    ],

                    [
                        'group' => 'Blake',
                        'title' => 'Blake Group',
                        'contact' => 'https://www.rug.nl/research/zernike/ssme/blake-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/ssme/blake-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/solid-state-materials-for-electronics/hdr_blake.png'
                    ]
                ]
            ],
            [
                'title' => 'Surfaces and Thin Films',
                'description' => 'Our mission is to carry out a competitive research program in the field of Surface and Interface Physics with particular emphasis on the preparation and analysis of crystalline organic thin films, functional molecules as well as molecular motors and switches on surfaces, and nanocomposites, while training young researchers at the master, PhD and postdoctoral level in state-of-the-art surface analysis techniques and research in the field of Surface and Interface Physics.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_stf.png',
                'groups' => [

                    [
                        'group' => 'Rudolf',
                        'title' => 'Surfaces and Thin Films',
                        'contact' => 'https://www.rug.nl/staff/p.rudolf/',
                        'link' => 'https://www.rug.nl/research/zernike/surfaces-and-thin-films/rudolf-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/rudolf-1-web-new.jpg'
                    ],

                    [
                        'group' => 'Stöhr',
                        'title' => 'Surface Science',
                        'contact' => 'https://www.rug.nl/staff/m.a.stohr/',
                        'link' => 'https://www.rug.nl/research/zernike/surfaces-and-thin-films/stohr-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/stoehr-1-web-new.jpg'
                    ]
                ]
            ],
            [
                'title' => 'Theory of Condensed Matter',
                'description' => 'The mission of our group is to model and understand fundamental electronic, magnetic, and optical properties of condensed-phase systems.',
                'photo' => 'https://www.rug.nl/research/zernike/images/topic_theocondmatphys.png',
                'groups' => [
                    [
                        'group' => 'Knoester',
                        'title' => 'Theory of Condensed Matter 1',
                        'contact' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/knoester-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/knoester-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/pictures/knoester-1-web_nieuw.jpg'
                    ],
                    [
                        'group' => 'Mostovoy',
                        'title' => 'Theory of Condensed Matter 2',
                        'contact' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/mostovoy-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/mostovoy-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/pictures/mostovoy-1-web_nieuw.jpg'
                    ],
                    [
                        'group' => 'Jansen',
                        'title' => 'Computational Spectroscopy',
                        'contact' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/jansen-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/jansen-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/theory-of-condensed-matter/pictures/thomas2015_nieuw.jpeg'
                    ],
                ]
            ],
        ];
    }

    public function index() : View
    {
        return view('study.research-groups.index')
            ->with('groups', $this->groups)
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/research-groups', 'text' => 'Research Groups'],
            ]);
    }

    public function show(string $slug) : View
    {
        $group = Arr::first(array_filter($this->groups, function ($group) use ($slug) : bool {
            return Str::slug($group['title']) === $slug;
        }));

        return view('study.research-groups.show')
            ->with('groups', $this->groups)
            ->with('group', $group)
            ->with('breadcrumbs', [
                ['url' => '/study', 'text' => 'Study'],
                ['url' => '/study/research-groups', 'text' => 'Research Groups'],
                ['text' => $group['title']],
            ]);
    }
}
