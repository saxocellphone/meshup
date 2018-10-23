import Node from './models/node.js';
import * as moveController from './controllers/moveController.js';
// define width and height
let width = document.body.clientWidth, height = document.body.clientHeight
// create SVG document and set its size
let draw = SVG('main').size(width, height).attr({id: "main_svg"});
moveController.setStage(draw);
moveController.enableMove();

//TODO: move this to the movecontroller
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