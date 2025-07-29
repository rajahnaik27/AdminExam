var url3 = "./COA.pdf";
console.log(url3);
var pdfDoc3 = null,
  pageNum3 = 1,
  pageRendering3 = false,
  pageNumPending3 = null,
  scale = 2,
  canvas3 = document.getElementById("canvas3_Idle"),
  ctx3 = canvas3.getContext("2d");

/**
 * Get page info from document, resize canvas accordingly, and render page.
 * @param num Page number.
 */
function renderPage3(num3) {
  pageRendering3 = true;
  // Using promise to fetch the page
  pdfDoc3.getPage(num3).then(function (page) {
    var viewport = page.getViewport({ scale: scale });
    canvas3.height = viewport.height;
    canvas3.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext3 = {
      canvasContext: ctx3,
      viewport: viewport,
    };
    var renderTask3 = page.render(renderContext3);

    // Wait for rendering to finish
    renderTask3.promise.then(function () {
      pageRendering3 = false;
      if (pageNumPending3 !== null) {
        // New page rendering is pending
        renderPage3(pageNumPending3);
        pageNumPending3 = null;
      }
    });
  });

  // Update page counters
  document.getElementById("page_num3").textContent = num3;
}

function queueRenderPage3(num3) {
  if (pageRendering) {
    pageNumPending3 = num3;
  } else {
    renderPage3(num3);
  }
}

/**
 * Displays previous page.
 */
function onPrevPage3() {
  if (pageNum3 <= 1) {
    return;
  }
  pageNum3--;
  queueRenderPage3(pageNum3);
}
document.getElementById("prev3").addEventListener("click", onPrevPage3);

/**
 * Displays next page.
 */
function onNextPage3() {
  if (pageNum3 >= pdfDoc3.numPages) {
    return;
  }
  pageNum3++;
  queueRenderPage3(pageNum3);
}
document.getElementById("next3").addEventListener("click", onNextPage3);

pdfjsLib.getDocument(url3).promise.then(function (pdfDoc3_) {
  pdfDoc3 = pdfDoc3_;
  document.getElementById("page_count3").textContent = pdfDoc3.numPages;

  // Initial/first page rendering
  renderPage3(pageNum3);
});
