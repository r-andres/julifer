
function RecordList ( parent, selectorCache ) {
     
     var self = this;
     this.selectorCache = selectorCache;
     this.elements = Array ();
     this.buildUi(parent);
     this.counter = 0;
    return this;
}



RecordList.prototype = {
    
    
    buildUi : function (parent) {
       
        var widget = document.createElement('div');
        parent.appendChild(widget);
 
        /* Menu */
        var newItemCmd = document.createElement('div');
        newItemCmd.innerHTML = "(+)"
        newItemCmd.addEventListener('click', this.cmdAddNewServicio  , false); 
        newItemCmd.ref = this;
        widget.appendChild(newItemCmd);
     
        /* List */ 
        var listWidget = document.createElement('table');
        widget.appendChild(listWidget);
  
        this.widget = widget; 
        this.listWidget = listWidget;
        
    },
    
    
  
    cmdAddNewServicio : function (obj) {
    	
       var newElement = new Servicio (this.ref, this.ref.selectorCache);
       newElement.cantidad = 1;
       newElement.servicio = "";
       this.ref.add(newElement);
    },
    
    
    add : function (element) {

    		var rowView = element.getRowEdit();
            this.listWidget.appendChild(rowView);
            
            element.rowView = rowView;
            element.index = this.counter;
            this.elements.push(element);
            this.counter ++;
    },
    
    addServicio : function (cantidad, servicio) {

    	var newElement = new Servicio (this, this.selectorCache);
        newElement.cantidad = cantidad;
        newElement.servicio = servicio;
        this.add(newElement);
    },
    
}


function Servicio (listObj, selectorCache)
{
    var self = this;
    this.listObj = listObj;
    this.selectorCache = selectorCache;
 
    
    this.buildUi ();
    return this;
    
}


Servicio.prototype = {
    
    buildUi : function () {
	
		var index = this.listObj.counter;
		
        var rowEdit = document.createElement('tr');
        var cellCantidad = document.createElement('td');
    	var cellServicio = document.createElement('td');
    	var cellDelete = document.createElement('td');
    	var cantidadField = document.createElement('input');
    	cantidadField.name= "cantidad_" + index;
    	var servicioField = document.createElement('select');
    	servicioField.innerHTML= this.selectorCache.innerHTML;
    	servicioField.name= "servicio_" + index;
    	var deleteButton = document.createElement('div');
    	deleteButton.innerHTML = "(X)";
    	deleteButton.addEventListener('click', this.cmdDelete  , false); 
    	deleteButton.listRef = this.listObj;
    	deleteButton.index = index;
            
    	cellCantidad.appendChild(cantidadField);
    	cellServicio.appendChild(servicioField);
    	cellDelete.appendChild(deleteButton);
    	
    	rowEdit.appendChild(cellCantidad);
    	rowEdit.appendChild(cellServicio);
        rowEdit.appendChild(cellDelete);
    	this.cantidadField = cantidadField;
    	this.servicioField = servicioField;
    	
    	this.editView = rowEdit;

       
    } ,
    

    get cantidad ()
    {
        return this.cantidadField.value;
    },

    set cantidad (x)
    {
        this.cantidadField.value = x;
    },
    
    get servicio ()
    {
        return this.servicioField.value;
    },

    set servicio (x)
    {
        this.servicioField.value = x;
    },
   
    
    getRowEdit : function () 
    {
    	return this.editView;
    },
    
    getRowView : function () 
    {
    	var row = document.createElement('tr');
    	var cellCantidad = document.createElement('td');
    	var cellServicio = document.createElement('td');
    	
    	cellCantidad.innerHTML = this.cantidad;
    	cellServicio.innerHTML = this.servicio;
    	
    	row.appendChild(cellCantidad);
    	row.appendChild(cellServicio);
    	
    	return row;
    },
    
    cmdDelete : function () 
    {
    	var list = this.listRef;
    	var currentEls = list.elements;
    	var indxToDelete = -1;
    	
    	for (i = 0; i < currentEls.length && indxToDelete == -1; i++) {
    		var el = currentEls[i];
    		if (el.index == this.index){
    			indxToDelete = i;
    		}
    		
    	}
    	
    	if (indxToDelete != -1) {
    		list.listWidget.removeChild(currentEls[indxToDelete].editView);
    		currentEls.splice(indxToDelete, 1);
    	} else {
    		alert("No puedo borrar " + this.index)
    	}
    },
}


