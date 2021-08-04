<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class ResearchGroupsController
{
    /**
     * @var string[][][][]|string[][]
     */
    private array $groups = [];

    public function __construct()
    {
        $this->groups = [
            [
                'title' => 'Bio-inspired Circuits & Systems',
                'description' => 'We aim to identify the principles of neural computation and implement them in fully parallel and low-power neuromorphic very-large-scale integration (VLSI) systems that offer the opportunity to overcome the limitations of traditional digital architectures. Hereby we develop silicon implementations of neural networks with learning abilities and biologically inspired sensor systems, which allow us to validate current theories of learning and computation.',
                'photo' => 'https://www.rug.nl/research/zernike/research/topic_tcm.png',
                'groups' => [
                    [
                        'group' => 'Chicca',
                        'title' => 'Bio-inspired Circuits & Systems',
                        'contact' => 'https://www.rug.nl/research/zernike/bio-inspired-circuits-and-systems/chicca-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/bio-inspired-circuits-and-systems/chicca-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/chicca-web-vk-150px.jpg'
                    ]
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
                    ],
                    [
                        'group' => 'Giuntoli',
                        'title' => 'Giuntoli group',
                        'contact' => 'https://www.rug.nl/research/zernike/micromechanics/giuntoli-group/contact',
                        'link' => 'https://www.rug.nl/research/zernike/micromechanics/giuntoli-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/micromechanics/giuntoli-group/giuntoli-150x150.jpg'
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
                'photo' => 'https://www.rug.nl/research/zernike/images/034_tbjh_0619_800x386px.jpg',
                'groups' => [
                    [
                        'group' => 'van Wees',
                        'title' => 'Magnon Spintronics in Magnetic Insulators',
                        'contact' => 'https://www.rug.nl/staff/b.j.van.wees/',
                        'link' => 'https://www.rug.nl/research/zernike/physics-of-nanodevices/van-wees-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/VanWees-1-WEB.jpg'
                    ],

                    [
                        'group' => 'van der Wal',
                        'title' => 'Physics of Quantum Devices',
                        'contact' => 'https://www.rug.nl/staff/c.h.van.der.wal/',
                        'link' => 'https://www.rug.nl/research/zernike/physics-of-nanodevices/van-der-wal-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/VanDerWal-1-WEB.jpg'
                    ],

                    [
                        'group' => 'Banerjee',
                        'title' => 'Spintronics in Functional Materials',
                        'contact' => 'https://www.rug.nl/staff/t.banerjee/',
                        'link' => 'https://www.rug.nl/research/zernike/physics-of-nanodevices/banerjee-group/',
                        'foto' => 'https://www.rug.nl/research/zernike/people/Banjeree-1-WEB.jpg'
                    ],
                    [
                        'group' => 'Marcos Diniz Guimaraes',
                        'title' => 'Opto-Spintronics of Nanostructures',
                        'contact' => 'https://www.rug.nl/staff/m.h.guimaraes/',
                        'link' => 'https://www.rug.nl/research/zernike/physics-of-nanodevices/guimaraes-group/',
                        'foto' => 'https://professorfrancken.nl/uploads/images/research-groups/marcos.jpg'
                    ],
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
            ]
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
            Assert::string($group['title']);

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
