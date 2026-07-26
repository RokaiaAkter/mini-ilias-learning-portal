'use strict';

const searchInput = document.querySelector('[data-course-search]');
const resultContainer = document.querySelector('[data-course-results]');

if (searchInput && resultContainer) {
    let timerId;

    searchInput.addEventListener('input', () => {
        window.clearTimeout(timerId);

        timerId = window.setTimeout(async () => {
            const query = searchInput.value.trim();
            resultContainer.setAttribute('aria-busy', 'true');

            try {
                const response = await fetch(`/api/courses?q=${encodeURIComponent(query)}`);

                if (!response.ok) {
                    throw new Error(`Search request failed with status ${response.status}`);
                }

                const payload = await response.json();

                resultContainer.innerHTML = payload.data.length
                    ? payload.data.map(renderCourseCard).join('')
                    : '<p>No matching courses found.</p>';
            } catch (error) {
                console.error(error);
                resultContainer.innerHTML = '<p>Search is temporarily unavailable.</p>';
            } finally {
                resultContainer.removeAttribute('aria-busy');
            }
        }, 250);
    });
}

function renderCourseCard(course) {
    return `
        <article class="card">
            <h2><a href="${escapeHtml(course.url)}">${escapeHtml(course.title)}</a></h2>
            <p>${escapeHtml(course.description.substring(0, 160))}</p>
            <p class="muted">Instructor: ${escapeHtml(course.instructor)}</p>
        </article>
    `;
}

function escapeHtml(value) {
    const element = document.createElement('div');
    element.textContent = String(value);
    return element.innerHTML;
}
