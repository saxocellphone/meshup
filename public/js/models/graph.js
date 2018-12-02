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