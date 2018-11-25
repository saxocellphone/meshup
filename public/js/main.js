import Node from './models/node.js';
import * as stageController from './controllers/stageController.js';

let width = document.body.clientWidth, height = document.body.clientHeight

let stage = stageController.default('main', width, height, {id: "main_svg"});
stageController.enableMove();
// stageController.enableZoom();    

let nodes = [];
for(let index in users){
    let user = users[index];
    let name = user['first_name'] + " " + user['last_name'].charAt(0) + ".";
    let node = new Node(stage, name, Math.random()*1000, Math.random()*500, (user['username'] == username));
    if((user['username'] == username)){
        window.selfnode = node;
    }
    nodes.push(node);
}

for(let i = 0; i < nodes.length; i++){
    //TODO: We want to make the stage append the node, not the other way around. 
    nodes[i].append();
}

nodes[0].tryAddConnection(nodes[1]);

// for(let i = 0; i < nodes.length; i++){
//     for(let j = 0; j < nodes.length; j++){
//         if(i == j) continue;
//         nodes[i].addConnection(nodes[j]);
//     }
// }