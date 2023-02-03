import React, {Fragment} from "react";
import styles from './Feed.module.scss';
import {Post} from "./Post/Post";

export interface IPosts {
    id: string;
    biography: string;
    profilePictureUrl: string;
    username: string;
    followedCount: number;
    followerCount : number;
    posts: [IPosts]
}

export const Feed: React.FunctionComponent = (props: { posts: IPosts }) => {
    return (
        <Fragment>
            <div className={styles.infosWrapper}>
                <img className={styles.profilePicture} src={props.posts.profilePictureUrl}/>
                <div className={styles.descriptionWrapper}>
                    <div className={styles.username}>{props.posts.username}</div>
                    <div className={styles.biography}>{props.posts.biography}</div>
                </div>
                <div className={styles.followWrapper}>
                    <div>Followers : {props.posts.followerCount}</div>
                    <div>Followed : {props.posts.followedCount}</div>
                </div>
            </div>
            <div className={styles.wrapper}>
                {props.posts.posts ? props.posts.posts.map(post => (
                    <Post post={post} key={post.id}/>
                )) : 'waiting datas'}
            </div>
        </Fragment>
    );
};
