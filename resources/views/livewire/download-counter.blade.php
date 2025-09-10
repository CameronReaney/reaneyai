<button onclick="downloadPDF()" 
        class="group/btn inline-flex items-center space-x-2 bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium border border-gray-700 hover:border-gray-500 transition-all duration-300 w-full justify-center">
    
    <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-y-0.5" 
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    
    <span>Download PDF</span>
</button>

<script>
function downloadPDF() {
    const link = document.createElement('a');
    link.href = '/SPBible.pdf';
    link.download = 'System-Prompts-Bible.pdf';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>