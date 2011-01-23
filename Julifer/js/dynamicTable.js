
function RecordList ( parent ) {
     
     var self = this;
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
        newItemCmd.innerHTML = "<img src='images/add.png' title='Añadir material'>";
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
    	
       var newElement = new Servicio (this.ref);
       newElement.cantidad = 1;
       newElement.servicio = "Material";
       newElement.precio = 0;
       newElement.descuento = 0;
       
       this.ref.add(newElement);
    },
    
    
    add : function (element) {
    		if (this.elements.length == 0) {
    			this.addTableHeader();
    		}
    	
    		var rowView = element.getRowEdit();
            this.listWidget.appendChild(rowView);
            
            element.rowView = rowView;
            element.index = this.counter;
            this.elements.push(element);
            this.counter ++;
    },
    
    addServicio : function (cantidad, servicio, precio, descuento) {

    	var newElement = new Servicio (this);
        newElement.cantidad = cantidad;
        newElement.servicio = servicio;
        newElement.precio = precio;
        newElement.descuento = descuento;
        this.add(newElement);
    },
    
    addTableHeader : function () {
    	
		var header = document.createElement('tr');
        var cellCantidad = document.createElement('th');
    	var cellServicio = document.createElement('th');
    	var cellPrecio = document.createElement('th');
    	var cellDescuento = document.createElement('th');
    	var cellDelete = document.createElement('th');
    	
    	cellCantidad.innerHTML = "Cantidad";
    	cellServicio.innerHTML = "Descripción";
    	cellPrecio.innerHTML = "Precio<br>(Unidad)";
    	cellDescuento.innerHTML = "Descuento<br>(%)";
    	
    	header.appendChild(cellCantidad);
    	header.appendChild(cellServicio);
    	header.appendChild(cellPrecio);
    	header.appendChild(cellDescuento);
    	header.appendChild(cellDelete);
    	this.tableHeader = header;
    	
    	this.listWidget.appendChild(header);
    },
    
    removeTableHeader : function () {
    	this.listWidget.removeChild(this.tableHeader);
    },
}


function Servicio (listObj)
{
    var self = this;
    this.listObj = listObj;
   
 
    
    this.buildUi ();
    return this;
    
}


Servicio.prototype = {
    
    buildUi : function () {
	
		var index = this.listObj.counter;
		var rowEdit = document.createElement('tr');

		var cellCantidad = document.createElement('td');
    	var cellServicio = document.createElement('td');
    	var cellPrecio = document.createElement('td');
    	var cellDescuento = document.createElement('td');
    	var cellDelete = document.createElement('td');
    	
    	var cantidadField = document.createElement('input');
    	cantidadField.name= "cantidad_" + index;
    	cantidadField.style.width="30px";
    	 
    	var servicioField = document.createElement('input');
    	servicioField.name= "material_" + index;
    	servicioField.style.width="180px";
    	
    	var precioField = document.createElement('input');
    	precioField.name= "precio_" + index;
    	precioField.style.width="40px";
    	
    	var descuentoField = document.createElement('input');
    	descuentoField.name= "descuento_" + index;
    	descuentoField.style.width="30px";
    	
    	var deleteButton = document.createElement('div');
    	deleteButton.innerHTML = "<img src='images/delete.png' title='Borrar material'>";
    	deleteButton.addEventListener('click', this.cmdDelete  , false); 
    	deleteButton.listRef = this.listObj;
    	deleteButton.index = index;
            
    	cellCantidad.appendChild(cantidadField);
    	cellServicio.appendChild(servicioField);
    	cellPrecio.appendChild(precioField);
    	cellDescuento.appendChild(descuentoField);
    	
    	cellDelete.appendChild(deleteButton);
    	
    	rowEdit.appendChild(cellCantidad);
    	rowEdit.appendChild(cellServicio);
    	rowEdit.appendChild(cellPrecio);
    	rowEdit.appendChild(cellDescuento);
        rowEdit.appendChild(cellDelete);
    	this.cantidadField = cantidadField;
    	this.servicioField = servicioField;
    	this.precioField = precioField;
    	this.descuentoField = descuentoField;
    	
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
   
    get precio ()
    {
        return this.precioField.value;
    },

    set precio (x)
    {
        this.precioField.value = x;
    },
    
    get descuento ()
    {
        return this.descuentoField.value;
    },

    set descuento (x)
    {
        this.descuentoField.value = x;
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
    	var cellPrecio= document.createElement('td');
    	var cellDescuento = document.createElement('td');
    	
    	cellCantidad.innerHTML = this.cantidad;
    	cellServicio.innerHTML = this.servicio;
    	cellPrecio.innerHTML = this.descuento;
    	cellDescuento.innerHTML = this.precio;
    	
    	row.appendChild(cellCantidad);
    	row.appendChild(cellServicio);
    	row.appendChild(cellPrecio);
    	row.appendChild(cellDescuento);
    	
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
    	
    		if (currentEls.length == 0) {
    			list.removeTableHeader();
    		}
    		
    	
    	} else {
    		alert("No puedo borrar " + this.index)
    	}
    	
    },
}


