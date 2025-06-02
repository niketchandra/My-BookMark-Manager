from fastapi import APIRouter, Request
from services import file_ops

router = APIRouter()

@router.post("/signin")
async def signin(request: Request):
    data = await request.json()
    users = file_ops.read_json("users/user_1.json")
    return {"message": "Signed in", "user": users}
