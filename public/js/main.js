import Node from './models/node.js';

// define width and height
let width = document.body.clientWidth, height = document.body.clientHeight
let zoom_lvl = 1;
// create SVG document and set its size
let draw = SVG('main').size(width, height).attr({id: "main_svg"});
let boxx = draw.viewbox().x;
let boxy = draw.viewbox().y;
let pan = false;
let initpos;

draw.on('mousedown', (e)=>{
    pan = true;
    initpos = {x: e.clientX, y: e.clientY };
});

draw.on('mousemove', (e)=>{
    if(pan){
        let dx = e.clientX - initpos.x;
        let dy = e.clientY - initpos.y;
        draw.viewbox(boxx - dx, boxy - dy, width*zoom_lvl, height*zoom_lvl);
    }
});

draw.on('mouseup', (e)=>{
    boxx = draw.viewbox().x;
    boxy = draw.viewbox().y;
    pan = false;
});

$('#zoomout').on('click', ()=>{
    zoom_lvl *= 1.1;
    draw.viewbox(-(width*zoom_lvl-width)/2,-(height*zoom_lvl-height)/2,width*zoom_lvl,height*zoom_lvl);
});


$('#zoomin').on('click', ()=>{
    zoom_lvl /= 1.1;
    draw.viewbox(-(width*zoom_lvl-width)/2,-(height*zoom_lvl-height)/2,width*zoom_lvl,height*zoom_lvl);
});

let nodes = [];

nodes.push(new Node(draw, "Clare", width/2, height/2));
nodes.push(new Node(draw, "Amanda", width/4, height/4));
nodes.push(new Node(draw, "Brian", 780, 520));
nodes.push(new Node(draw, "Victor", 1000, 420));
nodes.push(new Node(draw, "Selia", 280, 500));

for(let i = 0; i < nodes.length; i++){
    nodes[i].append();
}

for(let i = 0; i < nodes.length; i++){
    for(let j = 0; j < nodes.length; j++){
        if(i == j) continue;
        nodes[i].addConnection(nodes[j]);
    }
}