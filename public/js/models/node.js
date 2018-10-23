import Connection from './connection.js';
import {getRandomColor} from './utils.js';

class Node {
    constructor(svg, name, cx = 0, cy = 0){
        this.svg_ = svg;
        this.name_ = name; 
        this.color_ = getRandomColor();
        this.cx_ = cx;
        this.cy_ = cy;
        this.connections_ = [];
        this.neib_ = []
        this.radius_ = 50;
    }

    append() {
        let r = this.radius_;
        let node = this.svg_.group();
        let circle = this.svg_.circle(r*2).fill(this.color_).cx(r).cy(r);
        let text = this.svg_.text(this.name_).cx(r).cy(r);
        node.add(circle);
        node.add(text);
        node.cx(this.cx).cy(this.cy);
        this.node_ = node;
        this.makeObjectDraggable();
    }

    addConnection(node, addBackConn = null){
        this.neib_.push(node);
        if(addBackConn == null){
            let connection = new Connection(this.svg_, this, node);
            node.addConnection(this, connection);
            this.connections_.push(connection);
        } else {
            this.connections_.push(addBackConn);
        }
    }

    makeObjectDraggable(){
        let node = this.node_;
        node.draggable().on('dragmove', (e) => {
            let coord = node.attr('transform').split(',');
            this.cx_ = parseFloat(coord[coord.length-2]);
            this.cy_ = parseFloat(coord[coord.length-1].slice(0, -1));
            this.move();
        });
    }

    move(){
        let connections = this.connections_;
        if(connections.length != 0){
            for(let i = 0; i < connections.length; i++){
                connections[i].moveLine(this);
            }
        }
    }

    get cx() {
        return this.cx_;
    }

    get cy() {
        return this.cy_;
    }

    get radius() {
        return this.radius_;
    }

    get name() {
        return this.name_;
    }
}

export default Node;