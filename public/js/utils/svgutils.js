export function zoom(scale, transformMatrix) {
    console.log(transformMatrix);
    for (var i = 0; i < 4; i++) {
        transformMatrix[i] *= scale;
    }
    transformMatrix[4] += (1 - scale) * centerX;
    transformMatrix[5] += (1 - scale) * centerY;

    var newMatrix = "matrix(" +  transformMatrix.join(' ') + ")";
    return newMatrix;
}