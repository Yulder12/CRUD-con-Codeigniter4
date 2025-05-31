// Función para inicializar los combos dinámicos con Tom Select
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar cada select con clase tom-select
    const selects = document.querySelectorAll('.tom-select');

    selects.forEach((select) => {
        const dataUrl = select.getAttribute('data-url'); // Obtener la URL desde data-url
        
        // Configurar Tom Select
        new TomSelect(select, {
            create: false, // No permitir crear opciones nuevas
            valueField: 'id', // Campo para el valor
            labelField: 'text', // Campo para mostrar en la lista
            searchField: 'text', // Campo a buscar
            placeholder: 'Buscar...', // Texto de ayuda
            load: function (query, callback) {
                // Construir la URL con el término de búsqueda
                const url = query.length 
                    ? `${dataUrl}?Busca=${encodeURIComponent(query)}` 
                    : dataUrl;

                // Realizar la solicitud
                fetch(url)
                    .then((response) => {
                        if (!response.ok) throw new Error('Error al cargar los datos');
                        return response.json();
                    })
                    .then((data) => {
                        // Pasar los resultados a Tom Select
                        callback(data);
                    })
                    .catch(() => {
                        // En caso de error, devolver una lista vacía
                        callback([]);
                    });
            },
            maxOptions: 10, // Máximo de opciones a mostrar
            allowEmptyOption: true, // Permitir que no se seleccione nada
        });
    });
});
