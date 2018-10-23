class Connection {
    constructor(svg, node1, node2){
        this.svg_ = svg;
        this.node1_ = node1;
        this.node2_ = node2;
        this.makeConnection();
    }

    makeConnection(){
        let n1 = this.node1_;
        let n2 = this.node2_;
        this.drawConnection(n1, n2);
    }

    drawConnection(n1, n2){
        let line = this.svg_.line(n1.cx, n1.cy, n2.cx, n2.cy);
        line.stroke({ width: 5, color: '#fff'});
        this.line_ = line;
    }

    maniConnection(whichNode, cx, cy){
        if(whichNode === 1){
            this.line_.attr({
                x1 : cx,
                y1 : cy
            });
        } else {
            this.line_.attr({
                x2 : cx,
                y2 : cy
            });
        }
    }

    moveLine(node){
        let cx = node.cx + node.radius;
        let cy = node.cy + node.radius;
        this.node1_.name === node.name ? this.maniConnection(1, cx, cy) : this.maniConnection(2, cx, cy);
    }

    get node1(){
        return this.node1_;
    }

    get node2(){
        return this.node2_;
    }
}

export default Connection;