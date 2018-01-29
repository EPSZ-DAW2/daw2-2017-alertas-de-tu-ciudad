var dragSrcEl = null;

function handleDragStart(e) {
  dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.outerHTML);

  this.classList.add('dragElem');
}
function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Importante!!
  }
  this.classList.add('over');

  e.dataTransfer.dropEffect = 'move';  // transferencia del objeto
  return false;
}

function handleDragEnter(e) {
  
}

function handleDragLeave(e) {
  this.classList.remove('over');  //retiramos la clase over, visual.
}

function handleDrop(e) {

  if (e.stopPropagation) {
    e.stopPropagation(); // A veces daba problemas con los childs, evitamos que repita el paso para todos.
  }

  if (dragSrcEl != this) {
    this.parentNode.removeChild(dragSrcEl);
    var dropHTML = e.dataTransfer.getData('text/html');
    this.insertAdjacentHTML('beforebegin',dropHTML);
    var dropElem = this.previousSibling;
    addDnDHandlers(dropElem);
    
  }
  this.classList.remove('over');
  return false;
}

function handleDragEnd(e) {
	//Una vez soltamos el objetos, retiramos todas las etiquetas.
	//Ya sea la barra , realizada con el border, como las transparencia del objeto.
  this.classList.remove('over');
  this.classList.remove('dragElem');
}

function addDnDHandlers(elem) {
	//Activamos todos los Listener.
  elem.addEventListener('dragstart', handleDragStart, false);
  elem.addEventListener('dragenter', handleDragEnter, false)
  elem.addEventListener('dragover', handleDragOver, false);
  elem.addEventListener('dragleave', handleDragLeave, false);
  elem.addEventListener('drop', handleDrop, false);
  elem.addEventListener('dragend', handleDragEnd, false);

}
// Activamos los listener para todos los objetos con la clase .imagen_miniatura
var cols = document.querySelectorAll('#previsualizador .imagen_miniatura');
[].forEach.call(cols, addDnDHandlers);