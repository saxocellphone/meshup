import Node from './models/node.js';

// define width and height
let width = document.body.clientWidth, height = document.body.clientHeight

// create SVG document and set its size
let draw = SVG('main').size(width, height).attr({id: "main_svg"});
// draw background
let background = draw.rect(width, height).fill('#E3E8E6')

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