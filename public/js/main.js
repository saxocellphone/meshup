import Node from './models/node.js';
import * as stageController from './controllers/stageController.js';

let width = document.body.clientWidth, height = document.body.clientHeight

let stage = stageController.default('main', width, height, {id: "main_svg"});
stageController.enableMove();
stageController.enableZoom();    

let nodes = [];

nodes.push(new Node(stage, "Clare", width/2, height/2));
nodes.push(new Node(stage, "Amanda", width/4, height/4));
nodes.push(new Node(stage, "Brian", 780, 520));
nodes.push(new Node(stage, "Victor", 1000, 420));
nodes.push(new Node(stage, "Selia", 280, 500));

for(let i = 0; i < nodes.length; i++){
    //TODO: We want to make the stage append the node, not the other way around. 
    nodes[i].append();
}

for(let i = 0; i < nodes.length; i++){
    for(let j = 0; j < nodes.length; j++){
        if(i == j) continue;
        nodes[i].addConnection(nodes[j]);
    }
}