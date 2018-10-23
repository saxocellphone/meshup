
let stage;

let width = document.body.clientWidth, height = document.body.clientHeight;

let boxx, boxy;

let zoom_lvl = 1;

let pan = false;
let initpos;

export function setStage(svg){
    stage = svg;
    boxx = stage.viewbox().x;
    boxy = stage.viewbox().y;
}

export function enableMove(){
    stage.on('mousedown', (e)=>{
        pan = true;
        initpos = {x: e.clientX, y: e.clientY };
    });
    
    stage.on('mousemove', (e)=>{
        if(pan){
            let dx = e.clientX - initpos.x;
            let dy = e.clientY - initpos.y;
            stage.viewbox(boxx - dx, boxy - dy, width*zoom_lvl, height*zoom_lvl);
        }
    });
    
    stage.on('mouseup', (e)=>{
        boxx = stage.viewbox().x;
        boxy = stage.viewbox().y;
        pan = false;
    });
}

export function enableZoom(){
    // TODO: This function is very cluncky, init positions isn't set right
    window.addEventListener('wheel', function(e){
        e.preventDefault();
        if(e.deltaY < 0){
            zoom_lvl /= 1.05;
            stage.viewbox(-(width*zoom_lvl-width)/2,-(height*zoom_lvl-height)/2,width*zoom_lvl,height*zoom_lvl);
        } 
        if(e.deltaY > 0){
            zoom_lvl *= 1.05;
            stage.viewbox(-(width*zoom_lvl-width)/2,-(height*zoom_lvl-height)/2,width*zoom_lvl,height*zoom_lvl);
        }
        boxx = stage.viewbox().x;
        boxy = stage.viewbox().y;
    });
}