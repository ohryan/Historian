import { useState, useEffect } from 'react';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

export default function HistorianList() {
    const [listContent, setListContent] = useState(null);
    const [error, setError] = useState(null);


    useEffect(() => {
        const queryParams = { perPage: 1 }

        apiFetch({path: addQueryArgs('wp/v2/posts', queryParams)}).then( ( posts ) => {
            const postsByYear = {};

            posts.forEach(post => {
                const postDate = new Date(post.date);
                const year = postDate.getFullYear();

                if (!postsByYear[year]) {
                    postsByYear[year] = [];
                }

                postsByYear[year].push(post);
            });

            const listContainer = (
                <div id="historianblock-post-list">
                    {Object.entries(postsByYear).map(([year, yearPosts]) => (
                        <div key={year}>
                            <h4>{year}</h4>
                            <ul>
                                {yearPosts.map(post => (
                                    <li key={post.id}><a href={post.link}>{post.title.rendered}</a></li>
                                ))}
                            </ul>
                        </div>
                    ))}
                </div>
            );

            setListContent(listContainer);
            setError(null); // Clear any previ
        })
        .catch((error) => {
            setError(error.message || 'An error occurred while fetching data.');
            setListContent(null);
        });
    }, [])

    if (error) {
        return <div>Error: {error}</div>;
    }

    return listContent;

}