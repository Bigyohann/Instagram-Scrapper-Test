import React, {Fragment} from 'react';
import {Search} from "../Search/Search";
import {IPosts, Feed} from "../Feed/Feed";


export const Home: React.FunctionComponent = () => {
    const [posts, updatePosts] = React.useState({});

    const triggerButton = (data : IPosts) => {
        updatePosts(data);
    }
    return (
        <Fragment>
            <Search triggerButton={triggerButton}/>
            <Feed posts={posts}></Feed>
        </Fragment>
    );
};
