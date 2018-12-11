import Node from './models/node.js';
import * as stageController from './controllers/stageController.js';
import Meshup from './models/meshup.js';
import Graph from './models/graph.js';

let width = document.body.clientWidth, height = document.body.clientHeight

let stage = stageController.default('main', width, height, {id: "main_svg"});
stageController.enableMove();
// stageController.enableZoom();    

let graph = new Graph();

let meshup = new Meshup(self_username, graph);
meshup.fetchStatus(true);

Object.entries(adj_list).map(([username, attr]) => {
    let name = attr['firstname'] + " " + attr['lastname'].charAt(0) + ".";
    let node = new Node(stage, username, name, attr['connections'], Math.random()*width, Math.random()*height, (username == self_username));
    if((username == self_username)){
        window.selfnode = node;
    }
    graph.addNode(node);
})

for(let i = 0; i < graph.nodes.length; i++){
    //TODO: We want to make the stage append the node, not the other way around. 
    graph.nodes[i].append();
}
// Adds init connections
for(let i = 0; i < graph.nodes.length; i++){
    for(let j = 0; j < graph.nodes[i].neighbors.length; j++){
        let neib_node = graph.getNodeByUsername(graph.nodes[i].neighbors[j]);
        if(neib_node){
            graph.nodes[i].addConnection(neib_node);
        }
    }
}