/**
 * This class simply acts as a graph data structure. It allows to get properties of this graph. Currently it's 
 * just for getting nodes, but can be expanded upon in the future.
 */


class Graph {
    constructor(){
        this.nodes_ = [];
    }

    addNode(node){
        this.nodes_.push(node);
    }

    getNodeByUsername(username){
        for(let i = 0; i < this.nodes.length; i++){
            if(this.nodes[i].username == username){
                return this.nodes[i];
            }
        }
        return null;
    }

    numNode(){
        return this.nodes_.length;
    }

    get nodes() {
        return this.nodes_;
    }
}

export default Graph;