
var LocsA = [
    {
        lat: 23.747158,
        lon: 90.399013,
        title: 'New Eskaton Road',
        html: '<h3>New Eskaton Road</h3>',
        icon: 'http://maps.google.com/mapfiles/markerA.png',
        animation: google.maps.Animation.DROP
    },
    {
        lat: 23.748664,
        lon: 90.403619,
        title: 'Mogbazar Circle',
        html: '<h3>Content B1</h3>',
        icon: 'http://maps.google.com/mapfiles/markerB.png',
        show_infowindow: false
    },
    {
        lat: 23.751139,
        lon: 90.402160,
        title: 'Mogbazar Rail Cross',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        icon: 'http://maps.google.com/mapfiles/markerC.png'
    },
    {
        lat: 23.753535,
        lon: 90.400851,
        title: 'Hatirzheel',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        icon: 'http://maps.google.com/mapfiles/markerD.png'
    },
    {
        lat: 23.751885,
        lon: 90.398576,
        title: 'FDC Gate',
        html: [
            '<h3>FCD Gate Title</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        icon: 'http://maps.google.com/mapfiles/markerE.png'
    },
    {
        lat: 23.749843,
        lon: 90.393212,
        title: 'Kawranbazar',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        icon: 'http://maps.google.com/mapfiles/markerF.png'
    },
    {
        lat: 23.745794,
        lon: 90.394735,
        title: 'Banglamotor',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        icon: 'http://maps.google.com/mapfiles/markerG.png'
    }
];

var LocsBangladesh = [
    {
        lat: 23.810332,
        lon: 90.412518,
        title: 'Zone A1',
        html: '<h3>Territory Area</h3>',
        type : 'circle',
        circle_options: {
            radius: 200000
        },
        draggable: true,
        zoom: 7,
    }
];
var LocsRegion = [

    {
        lat: 23.749843,
        lon: 90.393212,
        title: 'Zone A1',
        html: '<h3>Content A1</h3>',
        type : 'circle',
        circle_options: {
            radius: 200
        },
        draggable: true
    },
    {
        lat: 23.745794,
        lon: 90.394735,
        title: 'Draggable',
        html: '<h3>Content B1</h3>',
        show_infowindow: false,
        visible: true,
        draggable: true
    },
    {
        lat: 23.748664,
        lon: 90.403619,
        title: 'Title C1',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        visible: true,
        draggable: true
    }
    ,
    {
        lat: 23.753535,
        lon: 90.400851,
        title: 'Title C1',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        visible: true,
        draggable: true
    }
];
var LocsAv2 = [

    {
        lat: 23.749843,
        lon: 90.393212,
        title: 'Zone A1',
        html: '<h3>Content A1</h3>',
        type : 'circle',
        circle_options: {
            radius: 200
        },
        draggable: true
    },
    {
        lat: 23.745794,
        lon: 90.394735,
        title: 'Draggable',
        html: '<h3>Content B1</h3>',
        show_infowindow: false,
        visible: true,
        draggable: true
    },
    {
        lat: 23.748664,
        lon: 90.403619,
        title: 'Title C1',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        visible: true,
        draggable: true
    }
    ,
    {
        lat: 23.753535,
        lon: 90.400851,
        title: 'Title C1',
        html: [
            '<h3>Content C1</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        visible: true,
        draggable: true
    }
];


var LocsB = [
    {
        lat: 52.1,
        lon: 11.3,
        title: 'Title A2',
        html: [
            '<h3>Content A2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8
    },
    {
        lat: 51.2,
        lon: 22.2,
        title: 'Title B2',
        html: [
            '<h3>Content B2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8
    },
    {
        lat: 49.4,
        lon: 35.9,
        title: 'Title C2',
        html: [
            '<h3>Content C2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 4
    },
    {
        lat: 47.8,
        lon: 15.6,
        title: 'Title D2',
        html: [
            '<h3>Content D2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 6
    }
];


var LocsBv2 = [
    {
        lat: 52.1,
        lon: 11.3,
        title: 'Title A2',
        html: [
            '<h3>Content A2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8
    },
    {
        lat: 51.2,
        lon: 22.2,
        title: 'Title B2',
        html: [
            '<h3>Content B2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 8,
        type : 'circle',
        circle_options: {
            radius: 100000
        }
    },
    {
        lat: 49.4,
        lon: 35.9,
        title: 'Title C2',
        html: [
            '<h3>Content C2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 4
    },
    {
        lat: 47.8,
        lon: 15.6,
        title: 'Title D2',
        html: [
            '<h3>Content D2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 6
    }
];


var LocsAB = LocsA.concat(LocsB);


var LocsC = [
    {
        lat: 45.4654,
        lon: 9.1866,
        title: 'Milan, Italy',
        type : 'circle',
        circle_options: {
            radius: 1000
        },
        visible: false
    },
    {
        lat: 47.36854,
        lon: 8.53910,
        title: 'Zurich, Switzerland'
    },
    {
        lat: 48.892,
        lon: 2.359,
        title: 'Paris, France'
    },
    {
        lat: 48.13654,
        lon: 11.57706,
        title: 'Munich, Germany'
    }
];

var LocsD = [

    // {
    //     lat: 23.747158,
    //     lon: 90.399013,
    //     title: 'New Eskaton Road',
    //     html: '<h3>New Eskaton Road</h3>',
    //     // visible: false
    // },
    // {
    //     lat: 23.748664,
    //     lon: 90.403619,
    //     title: 'Mogbazar Circle',
    //     html: '<h3>Content B1</h3>',
    //     stopover: true
    // },
    {
        lat: 23.746091,
        lon: 90.395194
    },
    {
        lat: 23.746261,
        lon: 90.395736
    },
    {
        lat: 23.746378,
        lon: 90.396157
    },
    {
        lat: 23.746607,
        lon: 90.396999
    },
    {
        lat: 23.746835,
        lon: 90.397828
    },
    {
        lat: 23.746901,
        lon: 90.398104
    },
    {
        lat: 23.747341,
        lon: 90.398085
    },
    {
        lat: 23.747913,
        lon: 90.398053
    },
    {
        lat: 23.748180,
        lon: 90.398018
    },
    {
        lat: 23.748036,
        lon: 90.396500
    },
    {
        lat: 23.748031,
        lon: 90.395768
    },
    {
        lat: 23.748031,
        lon: 90.395768
    },
    {
        lat: 23.748667,
        lon: 90.395966
    },
    {
        lat: 23.749349,
        lon: 90.397232
    },
    {
        lat: 23.750319,
        lon: 90.397967
    },
    {
        lat: 23.751352,
        lon: 90.399274
    },
    {
        lat: 23.751230,
        lon: 90.400781
    },
    {
        lat: 23.750893,
        lon: 90.400754
    },
    {
        lat: 23.750316,
        lon: 90.401621
    },
    {
        lat: 23.749909,
        lon: 90.401178
    },
    {
        lat: 23.749030,
        lon: 90.400658
    },
    {
        lat: 23.747827,
        lon: 90.400947
    },
    // {
    //     lat: 23.753535,
    //     lon: 90.400851,
    //     title: 'Hatirzheel',
    //     html: [
    //         '<h3>Content C1</h3>',
    //         '<p>Lorem Ipsum..</p>'
    //     ].join(''),
    //     zoom: 8,
    //     icon: 'http://maps.google.com/mapfiles/markerD.png'
    // },
    // {
    //     lat: 23.751885,
    //     lon: 90.398576,
    //     title: 'FDC Gate',
    //     html: [
    //         '<h3>FCD Gate Title</h3>',
    //         '<p>Lorem Ipsum..</p>'
    //     ].join(''),
    //     zoom: 8,
    //     icon: 'http://maps.google.com/mapfiles/markerE.png'
    // },
    // {
    //     lat: 23.749843,
    //     lon: 90.393212,
    //     title: 'Kawranbazar',
    //     html: [
    //         '<h3>Content C1</h3>',
    //         '<p>Lorem Ipsum..</p>'
    //     ].join(''),
    //     zoom: 8,
    //     icon: 'http://maps.google.com/mapfiles/markerF.png'
    // },
    // {
    //     lat: 23.745794,
    //     lon: 90.394735,
    //     title: 'Banglamotor',
    //     html: [
    //         '<h3>Content C1</h3>',
    //         '<p>Lorem Ipsum..</p>'
    //     ].join(''),
    //     zoom: 8,
    //     icon: 'http://maps.google.com/mapfiles/markerG.png'
    // }
];

var Circles = [
    {
        lat: 51.51386,
        lon: -0.09559,
        title: 'Draggable marker',
        circle_options: {
            radius: 160
        },
        stroke_options: {
            strokeColor: '#aaaa00',
            fillColor: '#eeee00'
        },
        draggable: true
    },
    {
        lat: 51.51420,
        lon: -0.09303,
        title: 'Draggable circle',
        circle_options: {
            radius: 50
        },
        stroke_options: {
            strokeColor: '#aa0000',
            fillColor: '#ee0000'
        },
        visible: false,
        draggable: true
    },
    {
        lat: 51.51498,
        lon: -0.09097,
        circle_options: {
            radius: 80
        },
        visible: false,
        draggable: true
    },
    {
        lat: 51.51328,
        lon: -0.09021,
        circle_options: {
            radius: 160,
            editable: true
        },
        title: 'Editable circle',
        html: 'Change my size',
        visible: false,
        draggable: true
    },
    {
        lat: 51.51211,
        lon: -0.09050,
        circle_options: {
            radius: 130
        },
        stroke_options: {
            strokeColor: '#00aa00',
            fillColor: '#00aa00'
        },
        visible: false
    },
    {
        lat: 51.51226,
        lon: -0.09435,
        circle_options: {
            radius: 100
        },
        draggable: true
    },
    {
        lat: 51.513,
        lon: -0.08410,
        type: 'marker',
        title: 'Simple marker',
        html: 'I\'m a simple marker.'
    }
];