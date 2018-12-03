import Connection from './connection.js';
import {getRandomColor} from '../utils/utils.js';
import '../../vender/jquery.js';

class Node {

    constructor(svg, username, name, neib, cx = 0, cy = 0, self_node){
        this.svg_ = svg;
        this.name_ = name; 
        this.username_ = username;
        this.color_ = getRandomColor();
        this.cx_ = cx;
        this.cy_ = cy;
        this.connections_ = [];
        this.neib_ = neib[0].split(',');
        this.radius_ = 35;
        this.is_self_node = self_node;
    }

    append() {
        const r = this.radius_;
        const node = this.svg_.group();
        const circle = this.svg_.circle(r*2).fill(this.color_).cx(r).cy(r);
        const text = this.svg_.text(this.name_).cx(r).cy(r);
        node.add(circle);
        node.add(text);
        node.cx(this.cx).cy(this.cy);
        if(this.is_self_node){
            const border = this.svg_.circle(r*2).cx(r).cy(r);
            border.attr({
                fill: '#fff'
              , 'fill-opacity': 0   
              , stroke: '#000'
              , 'stroke-width': 5
            });
            node.add(border);
        }
        this.node_ = node;
        this.makeObjectDraggable();
        if(!this.is_self_node){
            node.click((e) => {
                if(!dragging_node){
                    window.selfnode.tryAddConnection(this);
                }
            });
        }
    }

    tryAddConnection(node){
        $.ajax({
            url: "?&component=api&function=add_to_connect_queue",
            method: "POST",
            data: {
                "user_to_connect": node.username_
            }
        }).done((data) => {
            data = JSON.parse(data);
            if(data['status'] == "success"){
                alert("Sent a connection request to " + node.name);
            } else {
                alert("ERROR: " + data['json']);
            }
        });
    }

    addConnection(node, addBackConn = null){
        this.neib_.push(node);
        if(addBackConn == null){
            const connection = new Connection(this.svg_, this, node);
            node.addConnection(this, connection);
            this.connections_.push(connection);
        } else {
            this.connections_.push(addBackConn);
        }
    }

    makeObjectDraggable(){
        const node = this.node_;
        node.on('mousedown', (e)=>{
            setTimeout(function(){
                dragging_node = true;
            }, 100);
        });
        node.draggable().on('dragmove', (e) => {
            // TODO: Make this more efficient
            const coord = node.attr('transform').split(',');
            this.cx_ = parseFloat(coord[coord.length-2]) + this.radius;
            this.cy_ = parseFloat(coord[coord.length-1].slice(0, -1)) + this.radius;
            // let bbox = node.rbox().addOffset();
            // this.cx_ = bbox.x+8;
            // this.cy_ = bbox.y+8;
            // console.log(this.cx_, this.cy_, testx, testy)
            this.move();
        });
        node.draggable().on('dragend', (e) => {
            setTimeout(function(){
                dragging_node = false;
            }, 100);
        });
    }

    move(){
        const connections = this.connections_;
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

    get username() {
        return this.username_;
    }

    get neighbors() {
        return this.neib_;
    }
}

export default Node;