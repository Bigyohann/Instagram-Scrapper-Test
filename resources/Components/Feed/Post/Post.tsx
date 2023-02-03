import React, {Fragment} from 'react';
import styles from './Post.module.scss';

export interface IPost {
    caption: string;
    commentCount: number;
    imageUrl: string;
    likeCount: number;
}

interface IPostProps {
    post?: IPost;
    key?: string;
}

export const Post: React.FunctionComponent<IPostProps> = (props) => {

    return (
        <Fragment>
            <div className={styles.post}>
                <img className={styles.image} src={props.post.imageUrl}/>
                <div className={styles.caption}>{props.post.caption}</div>
            </div>
        </Fragment>
    );
};
