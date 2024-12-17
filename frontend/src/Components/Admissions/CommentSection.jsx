import React, { useState } from "react";
import avataSysedu from "../../Assets/Images/logo.png";
import avataUser from "../../Assets/Images/avatar.png";
import iconfacebook from "../../Assets/Images/icon-facebook.jpg";

export default function CommentSection() {
    const [comments, setComments] = useState([
        {
            id: 1,
            avatar: avataUser,
            name: "Phúc Hậu",
            text: "Đến tháng 9 trường còn xét tuyển pk ạ?",
            replies: [
                {
                    id: 1,
                    avatar: avataSysedu,
                    name: "Cao đẳng Sysedu",
                    text: "Chào em. Em ib đến page để được cán bộ tư vấn chi tiết nhé: https://caodang.sys.edu.vn/tuvansinhvien",
                },
            ],
        },
        {
            id: 2,
            name: "Thái Lộc",
            avatar: avataUser,
            text: "Trường mình có ngành Kĩ thuật Điện lạnh không vậy ạ",
            replies: [
                {
                    id: 2,
                    avatar: avataSysedu,
                    name: "Cao đẳng Sysedu",
                    text: "Chào em. Em đến website https://caodang.sys.edu.vn/tuvansinhvien để được cán bộ hỗ trợ nhé !!!",
                },
            ],
        },
        {
            id: 3,
            name: "Minh Khánh",
            avatar: avataUser,
            text: "Trường mình có ngành Kĩ thuật Điện lạnh không vậy ạ",
            replies: [
                {
                    id: 3,
                    avatar: avataSysedu,
                    name: "Cao đẳng Sysedu",
                    text: "Chào em. Em đến website https://caodang.sys.edu.vn/tuvansinhvien để được cán bộ hỗ trợ nhé !!!",
                },
            ],
        },
        {
            id: 4,
            name: "Nhân Nghĩa",
            avatar: avataUser,
            text: "Trường mình có ngành Kĩ thuật Điện lạnh không vậy ạ",
            replies: [
                {
                    id: 4,
                    avatar: avataSysedu,
                    name: "Cao đẳng Sysedu",
                    text: "Chào em. Em đến website https://caodang.sys.edu.vn/tuvansinhvien để được cán bộ hỗ trợ nhé !!!",
                },
            ],
        },
    ]);

    const [newComment, setNewComment] = useState("");

    const handleCommentSubmit = (e) => {
        e.preventDefault();
        if (newComment.trim()) {
            setComments([
                ...comments,
                {
                    id: comments.length + 1,
                    name: "Bạn",
                    text: newComment,
                    replies: [],
                },
            ]);
            setNewComment("");
        }
    };

    const loadMoreComments = () => {
        alert("Tải thêm 10 bình luận!");
    };

    return (
        <div className="bg-white">
            <div className="container mx-auto py-10">
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-lg font-semibold">4 bình luận</h2>
                    <div className="flex items-center text-sm text-gray-600 space-x-1">
                        <span>Sắp xếp theo</span>
                        <select className="border border-gray-300 rounded px-2 py-1 bg-white focus:outline-none">
                            <option>Mới nhất</option>
                            <option>Cũ nhất</option>
                        </select>
                    </div>
                </div>
                <form
                    onSubmit={handleCommentSubmit}
                    className="flex items-center mb-4 border-t"
                >
                    <img
                        src={avataUser}
                        alt="Avatar"
                        className="w-10 h-10 mt-8 rounded-full mr-3"
                    />
                    <input
                        type="text"
                        placeholder="Bình luận của bạn..."
                        value={newComment}
                        onChange={(e) => setNewComment(e.target.value)}
                        className="w-full mt-8 px-4 py-2 border border-gray-300 focus:outline-none focus:ring focus:border-blue-300 bg-gray-100 rounded-lg"
                    />
                </form>
                {comments.map((comment) => (
                    <div key={comment.id} className="mb-4 mt-8">
                        <div className="flex items-start mb-2">
                            <img
                                src={avataUser}
                                alt="avatar"
                                className="w-10 h-10 rounded-full mr-3"
                            />
                            <div>
                                <div className="bg-gray-100 rounded-lg p-2">
                                    <p className="font-semibold text-blue-700">
                                        {comment.name}
                                    </p>
                                    <p>{comment.text}</p>
                                </div>
                                <div className="flex items-center text-sm text-gray-500 space-x-4 mt-1">
                                    <button className="hover:underline">
                                        Thích
                                    </button>
                                    <button className="hover:underline">
                                        Phản hồi
                                    </button>
                                    <span>3 tháng</span>
                                </div>
                            </div>
                        </div>
                        {comment.replies.map((reply) => (
                            <div key={reply.id} className="ml-12 mb-2">
                                <div className="flex items-start">
                                    <img
                                        src={avataSysedu}
                                        alt="avatar"
                                        className="w-10 h-10 rounded-full mr-3"
                                    />
                                    <div>
                                        <div className="bg-gray-100 rounded-lg p-2">
                                            <p className="font-semibold text-blue-700">
                                                {reply.name}
                                            </p>
                                            <p>{reply.text}</p>
                                        </div>
                                        <div className="flex items-center text-sm text-gray-500 space-x-4 mt-1">
                                            <button className="hover:underline">
                                                Thích
                                            </button>
                                            <button className="hover:underline">
                                                Phản hồi
                                            </button>
                                            <span>3 tháng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                ))}
                <button
                    onClick={loadMoreComments}
                    className="mt-4 w-full py-2 bg-blue-600 text-center text-white font-semibold hover:bg-blue-400"
                >
                    Tải thêm 10 bình luận
                </button>
                <div className="mt-4 text-sm text-blue-600 flex items-center">
                    <img
                        src={iconfacebook}
                        alt="logo facebook"
                        className="w-5 h-5 mr-1"
                    />
                    <span>Plugin bình luận trên Facebook</span>
                </div>
            </div>
        </div>
    );
}
