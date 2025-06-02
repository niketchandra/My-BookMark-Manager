from fastapi import APIRouter

router = APIRouter()

@router.get("/bookmarks")
def list_bookmarks():
    return ["Bookmark 1", "Bookmark 2"]