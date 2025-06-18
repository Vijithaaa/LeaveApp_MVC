const today = new Date(). toISOString().split('T')[0]; 
document.getElementById('start_date').setAttribute('min',today);
document.getElementById('end_date').setAttribute('min',today);
