import Node from './models/node.js';

// define width and height
var width = document.body.clientWidth, height = document.body.clientHeight

// create SVG document and set its size
var draw = SVG('main').size(width, height).attr({id: "main_svg"});

// draw background
var background = draw.rect(width, height).fill('#E3E8E6')

let node1 = new Node(draw, "Clare", width/2, height/2);
let node2 = new Node(draw, "Amanda", width/4, height/4);
let node3 = new Node(draw, "Brian", 780, 520);
let node4 = new Node(draw, "Victor", 1000, 420);
let node5 = new Node(draw, "Selia", 280, 500);
node1.append();
node2.append();
node3.append();
node4.append();
node5.append();
// draw line
node1.addConnection(node2);
node1.addConnection(node3);
node5.addConnection(node4);
node4.addConnection(node3);
node4.addConnection(node1);